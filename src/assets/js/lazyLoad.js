/*img*/

let optionsLazy = {
    root: null,
    rootMargin: '0px',
    threshold: 0.1
};

let callbackLazy = (entries, observer) => {

    entries.forEach(entry => {
        let className = entry.target.className;
        let hasClassTrue = false;

        className = className.split(" ");

        for(let i =0 ; i < className.length; i++) {
            if(className[i] === 'imageLazy') {
                hasClassTrue = true;
                break;
            }
        }

        if (entry.isIntersecting && hasClassTrue) {

            let imageUrl = entry.target.getAttribute('data-img');
            if (imageUrl) {
                entry.target.src = imageUrl;
                observer.unobserve(entry.target);
            }
        }
    })
};

let observer = new IntersectionObserver(callbackLazy, optionsLazy);

let imageList = document.querySelectorAll('.imageLazy');

imageList.forEach(image => {
    observer.observe(image)
});


/*Youtube iframe*/



( function() {

    var youtube = document.querySelectorAll( ".youtube" );

    for (var i = 0; i < youtube.length; i++) {

        var source = "https://img.youtube.com/vi/"+ youtube[i].dataset.embed +"/sddefault.jpg";

        var image = new Image();
        image.src = source;
        image.addEventListener( "load", function() {
            youtube[ i ].appendChild( image );
        }( i ) );

        youtube[i].addEventListener( "click", function() {

            var iframe = document.createElement( "iframe" );

            iframe.setAttribute( "frameborder", "0" );
            iframe.setAttribute( "allowfullscreen", "" );
            iframe.setAttribute( "src", "https://www.youtube.com/embed/"+ this.dataset.embed +"?rel=0&showinfo=0&autoplay=1" );

            this.innerHTML = "";
            this.appendChild( iframe );
        } );
    };

} )();