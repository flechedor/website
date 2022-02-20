// Highlight title on scroll
const main = document.querySelector('main.content')
if (!main.classList.contains('page-agenda') && !main.classList.contains('page-event') && !main.classList.contains('page-contact')) {
    const titles = main.querySelectorAll('h1, h2')
    const activeMenuItem = document.querySelector('menu a.active + .sub-items')
    let titleId = 0
    let offsets = []
    if (activeMenuItem) {
        titles.forEach(title => {
            title.id = 'title' + titleId
            const link = document.createElement('a');
            link.innerHTML = title.innerHTML
            link.classList.add('sub-item', 'anchor-nav')
            link.addEventListener('click', (e) => {
                location.hash = null
                location.hash = "#" + title.id;
                e.preventDefault()
                setTimeout(() => {
                    // Force highlighting the link clicked (if it's the last one it might not be auto highlighted based on scroll)
                    document.querySelectorAll('.anchor-nav').forEach(l => l.classList.remove('active'))
                    link.classList.add('active')
                }, 10)
            })
            link.href = '#title' + titleId
            activeMenuItem.append(link)
            titleId = titleId + 1
            offsets.push({ value: title.offsetTop, link: link })
        })
    }

    main.addEventListener('scroll', function(e) {
        let activeLink = null
        offsets.forEach(offset => {
            offset.link.classList.remove('active')
            if ((main.scrollTop + 40) >= offset.value) activeLink = offset.link
        })
        if (activeLink) activeLink.classList.add('active')
    })
}

document.querySelector('.menu-button').addEventListener('click', function() {
    var nav = document.querySelector("nav");
    if (!nav.style.display || nav.style.display === "none") {
        nav.style.display = "block";
    } else {
        nav.style.display = "none";
    }
})