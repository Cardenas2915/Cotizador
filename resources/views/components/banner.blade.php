<div class="splide" role="group" aria-label="Splide Basic HTML Example">
    <div class="splide__track">
        <ul class="splide__list">
        <li class="splide__slide" data-splide-interval="3000"><img src="{{asset('slider/banner.png')}}" alt=""></li>
        <li class="splide__slide" data-splide-interval="3000"><img src="{{asset('slider/banner2.jpg')}}" alt=""></li>
        <li class="splide__slide" data-splide-interval="3000"><img src="{{asset('slider/banner3.jpg')}}" alt=""></li>
        </ul>
    </div>
</div>

<script>
    window.addEventListener('load', ()=> {
    
    const splideElements = document.querySelectorAll('.splide');

    // Recorre cada elemento y crea una instancia de Splide
    splideElements.forEach(element => {
        const splide = new Splide(element, {
            perPage: 1,
            type   : 'loop',
            rewind: true,
            autoplay: true,
            pauseOnHover: true
        });
    
        splide.mount();
    });
})
</script>