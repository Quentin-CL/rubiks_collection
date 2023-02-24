const links = document.querySelectorAll('nav li')
const navBar = document.querySelector('.js-navbar')

//default nav position on first item
navBar.style.left = `${links[0].offsetLeft}px`
navBar.style.width = `${links[0].offsetWidth}px`

links.forEach(link => {
    //onclick
    link.addEventListener('click', () => {
        navBar.style.left = `${link.offsetLeft}px`
        navBar.style.width = `${link.offsetWidth}px`
    })

    //on mouse enter
    link.addEventListener('mouseenter', () => {
        navBar.style.left = `${link.offsetLeft}px`
        navBar.style.width = `${link.offsetWidth}px`
    })
})  