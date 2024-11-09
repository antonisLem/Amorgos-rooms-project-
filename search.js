const search = () =>{
    const searchbox = document.getElementById("search").value.toUppercase();
    const roomlist = document.getElementById("room-list").value.toUppercase();
    const room = document.querySelectorAll(".room");
    const rname = document.getElementByTagName("h3");


    for(var i = 0; i<rname.lenght; i++){

        let match = room[i].getElementsByTagName('h3')[0];

        if(match){
           let textvalue =  match.textContent || match.innerHTML;

           if(textvalue.toUpperCase().indexOf(searchbox) > -1){
            room[i].display = "";
           }else{
            room[i].display = "none";
           }
        }
    }
}