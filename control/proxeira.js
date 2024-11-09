<script>
        function acceptUsers() {
            const selectedUsers = document.querySelectorAll('input[name="user"]:checked');
            const userIds = Array.from(selectedUsers).map(checkbox => checkbox.value);
            if (userIds.length > 0) {
                alert(`Accepted users: ${userIds.join(', ')}`);
                // Here you can add AJAX or other logic to send the userIds to your server for processing
            } else {
                alert('No users selected');
            }
        }
    </script>