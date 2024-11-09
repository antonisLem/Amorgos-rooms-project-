fetch("admins.json")
.then(function(response){
    return response.json();
})
.then(function(admins){
    let placeholder = document.querySelector("#admin-output");
    let output = "";
    for(let admin of admins){
        output +=` 
        <tr>
            <td>${admin.name}</td>
            <td>${admin.username}</td>
            <td>${admin.password}</td>
            <td>${admin.email}</td>
            <td>${admin.id}</td>
            <td><a href='delete_admin.php?id=${admin.id}' id='btn' class="btn">Delete</a></td>  
        </tr>
        `;
    }

    placeholder.innerHTML = output;
})

