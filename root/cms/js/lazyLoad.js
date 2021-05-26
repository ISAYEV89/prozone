console.log('workaaaaaaa')

let options =  {
    root: null,
    rootMargin : '0px',
    threshold: 0.1
}
console.log('work11')

let callback = (entries , observer) => {
    entries.forEach(entry => {
        if(entry.isIntersecting && entry.target.className === 'image-lazy') {
            let imageUrl = entry.target.getAttribute('data-img');
            if(imageUrl) {
                entry.target.src = imageUrl;
                observer.unobserve(entry.target);
            }
        }
    })
}

console.log('work22')

let observer = new  IntersectionObserver(callback, options)

let imageList = document.querySelectorAll('.image-popular')

console.log('work333')

imageList.forEach(image => {
    observer.observe(image)
})

console.log('work4444')