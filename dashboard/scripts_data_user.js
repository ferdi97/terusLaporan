document.addEventListener('DOMContentLoaded', function () {
    const loader = document.getElementById('loader');
    const tableBody = document.getElementById('table-body');
    const editModal = document.getElementById('editModal');
    const deleteModal = document.getElementById('deleteModal');
    const closeBtns = document.querySelectorAll('.close-btn');
    const editForm = document.getElementById('editForm');
    const editUserId = document.getElementById('editUserId');
    const editUsername = document.getElementById('editUsername');
    const editPassword = document.getElementById('editPassword');
    const editLevelUser = document.getElementById('editLevelUser');
    const confirmDelete = document.getElementById('confirmDelete');
    const cancelDelete = document.getElementById('cancelDelete');

    const customSelectWrapper = document.querySelector('.custom-select-wrapper');
    const customSelectTrigger = customSelectWrapper.querySelector('.custom-select-trigger');
    const customOptions = customSelectWrapper.querySelector('.custom-options');
    const selectElement = customSelectWrapper.querySelector('.custom-select');

    let deleteUserId = null;

    loader.style.display = 'block';

    // Function to fetch data from server
    function fetchData() {
        fetch('get_users.php?action=users')
            .then(response => response.json())
            .then(data => {
                let rows = '';
                data.forEach((item, index) => {
                    rows += `
                        <tr>
                            <td data-label="NO">${index + 1}</td>
                            <td data-label="USERNAME">${item.username}</td>
                            <td data-label="PASSWORD">${item.password}</td>
                            <td data-label="LEVEL USER">${item.level_user}</td>
                            <td data-label="AKSI">
                                <button class="edit-btn" data-id="${item.id}" data-username="${item.username}" data-password="${item.password}" data-level="${item.level_user}">Edit</button>
                                <button class="delete-btn" data-id="${item.id}">Delete</button>
                            </td>
                        </tr>
                    `;
                });
                tableBody.innerHTML = rows;
                loader.style.display = 'none';

                // Add event listeners to edit buttons
                document.querySelectorAll('.edit-btn').forEach(button => {
                    button.addEventListener('click', function () {
                        editUserId.value = this.getAttribute('data-id');
                        editUsername.value = this.getAttribute('data-username');
                        editPassword.value = this.getAttribute('data-password');
                        editLevelUser.value = this.getAttribute('data-level');
                        editModal.style.display = 'flex';
                    });
                });

                // Add event listeners to delete buttons
                document.querySelectorAll('.delete-btn').forEach(button => {
                    button.addEventListener('click', function () {
                        deleteUserId = this.getAttribute('data-id');
                        deleteModal.style.display = 'flex';
                    });
                });
            })
            .catch(error => {
                console.error('Error fetching data:', error);
                loader.style.display = 'none'; // Hide loader in case of error
            });
    }

    // Close modals on close button click
    closeBtns.forEach(btn => {
        btn.addEventListener('click', function () {
            editModal.style.display = 'none';
            deleteModal.style.display = 'none';
        });
    });

    // Close modals on window click outside modal content
    window.addEventListener('click', function (event) {
        if (event.target === editModal) {
            editModal.style.display = 'none';
        }
        if (event.target === deleteModal) {
            deleteModal.style.display = 'none';
        }
    });

    // Handle form submission for editing user
    editForm.addEventListener('submit', function (event) {
        event.preventDefault();
        const id = editUserId.value;
        const username = editUsername.value;
        const password = editPassword.value;
        const level_user = editLevelUser.value;

        fetch('proses_edit.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: `action=edit_user&id=${id}&username=${username}&password=${password}&level_user=${level_user}`,
        })
            .then(response => response.json())
            .then(result => {
                if (result.status === 'success') {
                    alert('User updated successfully');
                    editModal.style.display = 'none';
                    fetchData();
                } else {
                    alert('Error updating user');
                }
            })
            .catch(error => {
                console.error('Error updating user:', error);
            });
    });

    // Function to delete a user
    confirmDelete.addEventListener('click', function () {
        if (deleteUserId) {
            fetch('data_fetch.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: `action=delete_user&id=${deleteUserId}`,
            })
                .then(response => response.json())
                .then(result => {
                    if (result.status === 'success') {
                        alert('User deleted successfully');
                        deleteModal.style.display = 'none';
                        deleteUserId = null;
                        fetchData();
                    } else {
                        alert('Error deleting user');
                    }
                })
                .catch(error => {
                    console.error('Error deleting user:', error);
                });
        }
    });

    // Cancel delete action
    cancelDelete.addEventListener('click', function () {
        deleteModal.style.display = 'none';
        deleteUserId = null;
    });

    // Handle custom select dropdown
    customSelectTrigger.addEventListener('click', function () {
        customOptions.style.display = customOptions.style.display === 'block' ? 'none' : 'block';
    });

    customOptions.addEventListener('click', function (event) {
        if (event.target.classList.contains('custom-option')) {
            customSelectTrigger.textContent = event.target.textContent;
            selectElement.value = event.target.getAttribute('data-value');
            customOptions.style.display = 'none';
        }
    });

    window.addEventListener('click', function (event) {
        if (!customSelectWrapper.contains(event.target)) {
            customOptions.style.display = 'none';
        }
    });

    // Fetch data on load
    fetchData();
});
