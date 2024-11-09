fetch("rooms.json")
.then(function(response){
    return response.json();
})
.then(function(rooms){
    let placeholder = document.querySelector("#rooms-output");
    let output = "";
    for(let room of rooms){
        output +=` 
        <tr>
            <td>${room.name}</td>
            <td>${room.description}</td>
            <td>${room.email}</td>
            <td>${room.phone}</td>
            <td><a href="${room.link}" id='link' class="btn" target="_blank">link</a></td>
            <td><img src='rooms/${room.image}' alt='Room Image'></td>
            <td>${room.area}</td>
            <td>${room.id}</td>
            <td><a href='delete_room.php?id=${room.id}' id='btn' class="btn">Delete</a></td>  
        </tr>
        `;
    }

    placeholder.innerHTML = output;
})

