const deleteUserBtn= document.getElementsByClassName('delete');
const movieDuration= document.getElementById("duration");

for(let i=0; i<deleteUserBtn.length; i++){
    deleteUserBtn[i].addEventListener('click',()=>{
        const confirm = window.confirm(`Are you sure to delete ${deleteUserBtn[i].title}?`);
        if(!confirm){
            deleteUserBtn[i].setAttribute('href',  `${deleteUserBtn[i].name}.php`);
        }
    })
}


// movieDuration.addEventListener('keyup', ()=>{
//     if(movieDuration.value[2]){
//         movieDuration.value[2]= ":";
//     }
// })