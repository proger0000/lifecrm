/**
 * Утиліта для роботи з IndexedDB для офлайн функціональності
 * Забезпечує збереження та синхронізацію даних при відсутності з'єднання
 */

class OfflineDB {
    constructor() {
      this.dbName = 'KlsOfflineDB';
      this.dbVersion = 1;
      this.db = null;
      this.isOnline = navigator.onLine;
  
      // Слухачі онлайн/офлайн стану
      window.addEventListener('online', () => {
        this.isOnline = true;
        this.triggerSync();
      });
      window.addEventListener('offline', () => {
        this.isOnline = false;
      });
  
      // Реєстрація слухача повідомлень від service worker
      navigator.serviceWorker.addEventListener('message', (event) => {
        if (event.data && event.data.type === 'SYNC_COMPLETED') {
          // Оновити UI після успішної синхронізації
          document.dispatchEvent(new CustomEvent('sync-completed', { detail: event.data }));
        }
      });
    }
  
    /**
     * Ініціалізація бази даних
     */
    async init() {
      if (this.db) return this.db;
  
      return new Promise((resolve, reject) => {
        const request = indexedDB.open(this.dbName, this.dbVersion);
  
        request.onerror = (event) => {
          console.error('Помилка відкриття IndexedDB:', event.target.error);
          reject(event.target.error);
        };
  
        request.onsuccess = (event) => {
          this.db = event.target.result;
          console.log('IndexedDB успішно відкрито');
          resolve(this.db);
        };
  
        request.onupgradeneeded = (event) => {
          const db = event.target.result;
          
          // Створення сховищ для офлайн даних
          if (!db.objectStoreNames.contains('pendingShifts')) {
            db.createObjectStore('pendingShifts', { keyPath: 'localId', autoIncrement: true });
          }
          
          if (!db.objectStoreNames.contains('pendingReports')) {
            db.createObjectStore('pendingReports', { keyPath: 'localId', autoIncrement: true });
          }
          
          // Кешування користувачів
          if (!db.objectStoreNames.contains('users')) {
            db.createObjectStore('users', { keyPath: 'id' });
          }
          
          // Кешування постів
          if (!db.objectStoreNames.contains('posts')) {
            db.createObjectStore('posts', { keyPath: 'id' });
          }
          
          // Кешування змін
          if (!db.objectStoreNames.contains('shifts')) {
            db.createObjectStore('shifts', { keyPath: 'id' });
          }
        };
      });
    }
  
    /**
     * Збереження даних зміни для подальшої синхронізації
     * @param {Object} shiftData - Дані зміни для зберігання
     */
    async saveShift(shiftData) {
      await this.init();
      
      return new Promise((resolve, reject) => {
        const transaction = this.db.transaction(['pendingShifts'], 'readwrite');
        const store = transaction.objectStore('pendingShifts');
        
        // Додаємо мітку часу для сортування
        const dataToSave = {
          ...shiftData,
          timestamp: Date.now(),
          synced: false
        };
        
        const request = store.add(dataToSave);
        
        request.onsuccess = () => {
          console.log('Зміну збережено для офлайн синхронізації');
          
          // Якщо онлайн, спробуйте синхронізувати відразу
          if (this.isOnline && 'serviceWorker' in navigator && navigator.serviceWorker.controller) {
            navigator.serviceWorker.ready.then(registration => {
              registration.sync.register('sync-shifts');
            });
          }
          
          resolve(request.result);
        };
        
        request.onerror = (event) => {
          console.error('Помилка збереження зміни:', event.target.error);
          reject(event.target.error);
        };
      });
    }
  
    /**
     * Збереження звіту для подальшої синхронізації
     * @param {Object} reportData - Дані звіту для зберігання
     */
    async saveReport(reportData) {
      await this.init();
      
      return new Promise((resolve, reject) => {
        const transaction = this.db.transaction(['pendingReports'], 'readwrite');
        const store = transaction.objectStore('pendingReports');
        
        const dataToSave = {
          ...reportData,
          timestamp: Date.now(),
          synced: false
        };
        
        const request = store.add(dataToSave);
        
        request.onsuccess = () => {
          console.log('Звіт збережено для офлайн синхронізації');
          
          if (this.isOnline && 'serviceWorker' in navigator && navigator.serviceWorker.controller) {
            navigator.serviceWorker.ready.then(registration => {
              registration.sync.register('sync-reports');
            });
          }
          
          resolve(request.result);
        };
        
        request.onerror = (event) => {
          console.error('Помилка збереження звіту:', event.target.error);
          reject(event.target.error);
        };
      });
    }
  
    /**
     * Отримання всіх несинхронізованих змін
     */
    async getPendingShifts() {
      await this.init();
      
      return new Promise((resolve, reject) => {
        const transaction = this.db.transaction(['pendingShifts'], 'readonly');
        const store = transaction.objectStore('pendingShifts');
        const request = store.getAll();
        
        request.onsuccess = () => {
          resolve(request.result);
        };
        
        request.onerror = (event) => {
          reject(event.target.error);
        };
      });
    }
  
    /**
     * Отримання всіх несинхронізованих звітів
     */
    async getPendingReports() {
      await this.init();
      
      return new Promise((resolve, reject) => {
        const transaction = this.db.transaction(['pendingReports'], 'readonly');
        const store = transaction.objectStore('pendingReports');
        const request = store.getAll();
        
        request.onsuccess = () => {
          resolve(request.result);
        };
        
        request.onerror = (event) => {
          reject(event.target.error);
        };
      });
    }
  
    /**
     * Кешування списку постів для офлайн-доступу
     * @param {Array} posts - Масив постів для кешування
     */
    async cachePosts(posts) {
      await this.init();
      
      return new Promise((resolve, reject) => {
        const transaction = this.db.transaction(['posts'], 'readwrite');
        const store = transaction.objectStore('posts');
        
        let completed = 0;
        let errors = 0;
        
        posts.forEach(post => {
          const request = store.put(post);
          
          request.onsuccess = () => {
            completed++;
            if (completed + errors === posts.length) {
              resolve();
            }
          };
          
          request.onerror = () => {
            errors++;
            if (completed + errors === posts.length) {
              if (errors === posts.length) {
                reject(new Error('Не вдалося зберегти пости'));
              } else {
                resolve();
              }
            }
          };
        });
        
        if (posts.length === 0) {
          resolve();
        }
      });
    }
  
    /**
     * Отримання кешованих постів
     */
    async getCachedPosts() {
      await this.init();
      
      return new Promise((resolve, reject) => {
        const transaction = this.db.transaction(['posts'], 'readonly');
        const store = transaction.objectStore('posts');
        const request = store.getAll();
        
        request.onsuccess = () => {
          resolve(request.result);
        };
        
        request.onerror = (event) => {
          reject(event.target.error);
        };
      });
    }
  
    /**
     * Запускає синхронізацію даних, якщо пристрій онлайн
     */
    async triggerSync() {
      if (!this.isOnline || !('serviceWorker' in navigator) || !navigator.serviceWorker.controller) {
        return false;
      }
      
      const pendingShifts = await this.getPendingShifts();
      const pendingReports = await this.getPendingReports();
      
      if (pendingShifts.length > 0) {
        await navigator.serviceWorker.ready.then(registration => {
          return registration.sync.register('sync-shifts');
        });
      }
      
      if (pendingReports.length > 0) {
        await navigator.serviceWorker.ready.then(registration => {
          return registration.sync.register('sync-reports');
        });
      }
      
      return true;
    }
  
    /**
     * Очищення конкретного сховища
     * @param {string} storeName - Назва сховища для очищення
     */
    async clearStore(storeName) {
      await this.init();
      
      return new Promise((resolve, reject) => {
        const transaction = this.db.transaction([storeName], 'readwrite');
        const store = transaction.objectStore(storeName);
        const request = store.clear();
        
        request.onsuccess = () => {
          resolve();
        };
        
        request.onerror = (event) => {
          reject(event.target.error);
        };
      });
    }
  
    /**
     * Отримання кількості несинхронізованих змін та звітів
     */
    async getPendingCount() {
      const shifts = await this.getPendingShifts();
      const reports = await this.getPendingReports();
      
      return {
        shifts: shifts.length,
        reports: reports.length,
        total: shifts.length + reports.length
      };
    }
  }
  
  // Експортуємо єдиний екземпляр для використання в додатку
  export const offlineDB = new OfflineDB();