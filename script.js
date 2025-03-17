const Stars = document.querySelectorAll(".Stars span");
Stars.forEach((star, index1) => {
    star.addEventListener("click",() =>{
        Stars.forEach((star, index2) => {
            index1 >= index2 ? star.classList.add("active"): star.classList.remove("active")
                   });
    });
});
const menu = document.querySelector('.menu')
const menuList = document.querySelector('nav ul')
menu.addEventListener('click',()=>{
    menuList.classList.toggle('showmenu')
})

