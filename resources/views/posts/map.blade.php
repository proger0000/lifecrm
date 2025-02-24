@extends('app')

@section('content')
<div class="container mx-auto px-4">
    <h1 class="text-2xl font-bold mb-4">Карта постов</h1>
    <div id="map" style="height: 500px;"></div>
</div>
@endsection

@section('scripts')
<script>
    function initMap() {
        // Центр карты можно задать, например, на центр вашего региона
        var map = new google.maps.Map(document.getElementById('map'), {
            zoom: 10,
            center: {lat: 50.438872, lng: 30.572219} 
        });

        // Передаём данные постов из PHP в JS
        var markers = @json($posts);

        // Для каждого поста создаём маркер на карте
        markers.forEach(function(post) {
            var marker = new google.maps.Marker({
                position: {lat: parseFloat(post.latitude), lng: parseFloat(post.longitude)},
                map: map,
                title: post.name
            });
        });
    }
</script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyD_IPIP0Tu-j9XF4Lmu9i_ik0ESB4kHaqw&callback=initMap"
        async defer></script>
@endsection
