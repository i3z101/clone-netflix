const quesSection= document.getElementsByClassName('ques');
const answSection= document.getElementsByClassName('answ');
const openIcons= document.getElementsByClassName('open');
const closeIcons= document.getElementsByClassName('close');
const drawer= document.querySelector(".drawer");
const drawerContent= document.querySelector(".ul");
const menuBtn= document.querySelector(".menu");
const closeDrawer= document.querySelector('.close-drawer');
const body= document.querySelector('body');
const moviesParts= document.getElementsByClassName('movie');
const movieDetails= document.getElementsByClassName('movie-detail');

for(let i=0; i<quesSection.length; i++){
    quesSection[i].addEventListener('click', ()=>{
        if(openIcons[i].classList.contains('display')){
            openIcons[i].classList.remove('display');
            openIcons[i].classList.add('hide');
        }else{
            openIcons[i].classList.remove('hide');
            openIcons[i].classList.add('display');
        }
        if(closeIcons[i].classList.contains('display')){
            closeIcons[i].classList.remove('display');
            closeIcons[i].classList.add('hide');
        }else{
            closeIcons[i].classList.remove('hide');
            closeIcons[i].classList.add('display');
        }

        if(answSection[i].classList.contains('display')){
            answSection[i].classList.remove('display');
            answSection[i].classList.add('hide');
        }else{
            answSection[i].classList.remove('hide');
            answSection[i].classList.add('display');
        }
        
    })
}



menuBtn.addEventListener('click', ()=>{
    drawer.classList.add('show');
    drawerContent.style.display= "flex";
    
})

closeDrawer.addEventListener('click', ()=>{
   if(drawer.classList.contains("show")){
       drawer.classList.remove("show");
       drawerContent.style.display= "none";
   }
})


// body.addEventListener('mouseleave')
for(let i=0; i<moviesParts.length; i++){
    moviesParts[i].addEventListener('mouseover', ()=>{
        setTimeout(()=>{
            movieDetails[i].style.display= 'block';
            moviesParts[i].style.width= '100%'
        }, 300)
    })
}

for(let i=0; i<moviesParts.length; i++){
    moviesParts[i].addEventListener('mouseleave', ()=>{
        setTimeout(()=>{
            movieDetails[i].style.display= 'none';  
        }, 300)
    })
}