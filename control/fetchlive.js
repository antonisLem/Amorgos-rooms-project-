fetch("liverooms.json")
.then(function(response){
    return response.json();
})
.then(function(lives){
    let placeholder = document.querySelector("#live-output");
    let output = "";
    for(let live of lives){
        output +=` 
        <tr>
            <td>${live.name}</td>
            <td>${live.description}</td>
            <td>${live.email}</td>
            <td>${live.phone}</td>
            <td><a href="${live.link}" id='link' class="btn" target="_blank">link</a></td>
            <td><img src='rooms/${live.image}' alt='Room Image'></td>
            <td>${live.area}</td>
            <td>${live.id}</td>
            <td><a href='delete_live.php?id=${live.id}' id='btn' class="btn">Delete</a></td>  
        </tr>
        `;
    }

    placeholder.innerHTML = output;
})

