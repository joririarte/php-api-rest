// URL BASE DE LA API A CONSULTAR
const baseUrl = 'http://localhost/api-rest/';

// EVENTO QUE SE EJECUTA CUANDO LA PÁGINA TERMINA DE CARGAR
document.addEventListener('DOMContentLoaded', function () {
    loadTableData(); // Carga los datos de la tabla al iniciar
});

// FUNCIÓN PARA OBTENER Y LLENAR LA TABLA CON DATOS DE LA BASE DE DATOS
function loadTableData() {
    fetch(baseUrl + 'get_all_client.php') // Realiza una solicitud a la API para obtener todos los registros
        .then(response => response.json()) // Convierte la respuesta en un objeto JSON
        .then(data => {
            const tableBody = document.getElementById('userTableBody'); // Obtiene el cuerpo de la tabla
            // Limpia el contenido actual de la tabla
            tableBody.innerHTML = `
                <tr>
                    <!-- Fila para añadir nuevos registros -->
                    <td><input type="text" class="form-control" id="newId" disabled></td>
                    <td><input type="text" class="form-control" id="newEmail"></td>
                    <td><input type="text" class="form-control" id="newName"></td>
                    <td><input type="text" class="form-control" id="newCity"></td>
                    <td><input type="text" class="form-control" id="newPhone"></td>
                    <td>
                        <button class="btn btn-success btn-sm" onclick="addNewRecord()"><i class="fas fa-plus"></i></button>
                    </td>
                </tr>
            `;

            // Itera sobre los datos recibidos y crea filas para cada registro
            data.forEach(user => {
                const newRow = document.createElement('tr');

                newRow.innerHTML = `
                    <td>${user.id}</td> <!-- ID del usuario -->
                    <td class="editable" data-field="email">${user.email}</td> <!-- Email -->
                    <td class="editable" data-field="name">${user.name}</td> <!-- Nombre -->
                    <td class="editable" data-field="city">${user.city}</td> <!-- Ciudad -->
                    <td class="editable" data-field="telephone">${user.telephone}</td> <!-- Teléfono -->
                    <td>
                        <!-- Botones para editar, eliminar, guardar o cancelar -->
                        <button class="btn btn-warning btn-sm" onclick="editRecord(this)"><i class="fas fa-edit"></i></button>
                        <button class="btn btn-danger btn-sm" onclick="deleteRecord(${user.id})"><i class="fas fa-trash-alt"></i></button>
                        <button class="btn btn-success btn-sm d-none" onclick="saveRecord(${user.id}, this)"><i class="fas fa-save"></i></button>
                        <button class="btn btn-secondary btn-sm d-none" onclick="cancelEdit(this)"><i class="fas fa-times"></i></button>
                    </td>
                `;

                tableBody.insertBefore(newRow, tableBody.lastElementChild); // Inserta la nueva fila antes de la última fila (añadir nuevo registro)
            });
        })
        .catch(error => console.error('Error al obtener los datos:', error)); // Manejo de errores en la consulta
}

// FUNCIÓN PARA AÑADIR UN NUEVO REGISTRO
function addNewRecord() {
    const email = document.getElementById('newEmail').value;
    const name = document.getElementById('newName').value;
    const city = document.getElementById('newCity').value;
    const phone = document.getElementById('newPhone').value;

    // Verifica que todos los campos estén llenos
    if (email && name && city && phone) {
        fetch(baseUrl + 'create_client.php', {
            method: 'POST', // Método para crear un nuevo registro
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded' // Tipo de contenido
            },
            body: new URLSearchParams({
                email: email,
                name: name,
                city: city,
                telephone: phone
            })
        })
            .then(response => {
                if (response.ok) {
                    loadTableData(); // Recarga la tabla
                    // Limpia los campos del formulario
                    document.getElementById('newEmail').value = '';
                    document.getElementById('newName').value = '';
                    document.getElementById('newCity').value = '';
                    document.getElementById('newPhone').value = '';
                } else {
                    alert('Error al añadir el nuevo registro'); // Mensaje de error
                }
            })
            .catch(error => console.error('Error al añadir el nuevo registro:', error)); // Manejo de errores
    } else {
        alert('Por favor, complete todos los campos.'); // Alerta si faltan campos
    }
}

// FUNCIÓN PARA ELIMINAR UN REGISTRO
function deleteRecord(id) {
    fetch(baseUrl + 'delete_client.php?id=' + id, {
        method: 'DELETE', // Método para eliminar
        headers: {
            'Content-Type': 'application/json' // Tipo de contenido
        }
    })
        .then(response => {
            if (response.ok) {
                loadTableData(); // Recarga la tabla después de eliminar
            } else {
                alert('Error al borrar el registro'); // Mensaje de error
            }
        })
        .catch(error => console.error('Error al borrar el registro:', error)); // Manejo de errores
}

// FUNCIÓN PARA EDITAR UN REGISTRO
function editRecord(button) {
    const row = button.closest('tr'); // Obtiene la fila del botón presionado
    const cells = row.querySelectorAll('.editable'); // Obtiene las celdas editables

    cells.forEach(cell => {
        const input = document.createElement('input'); // Crea un campo de entrada
        input.type = 'text';
        input.className = 'form-control';
        input.value = cell.textContent; // Asigna el valor actual al campo de entrada
        cell.textContent = ''; // Limpia el contenido de la celda
        cell.appendChild(input); // Inserta el campo de entrada en la celda
    });

    toggleEditButtons(row, true); // Habilita los botones de guardar y cancelar
}

// FUNCIÓN PARA GUARDAR LOS CAMBIOS DE UN REGISTRO
function saveRecord(id, button) {
    const row = button.closest('tr');
    const cells = row.querySelectorAll('.editable');
    const updatedData = {}; // Objeto para almacenar los datos actualizados

    cells.forEach(cell => {
        const field = cell.dataset.field; // Obtiene el campo (email, name, etc.)
        const input = cell.querySelector('input');
        updatedData[field] = input.value; // Guarda el valor actualizado
        cell.textContent = input.value; // Muestra el nuevo valor en la celda
    });

    fetch(baseUrl + `update_client.php?id=${id}&email=${updatedData.email}&name=${updatedData.name}&city=${updatedData.city}&telephone=${updatedData.telephone}`, {
        method: 'PUT', // Método para actualizar
        headers: {
            'Content-Type': 'application/json'
        }
    })
        .then(response => {
            if (response.ok) {
                toggleEditButtons(row, false); // Desactiva los botones de edición
            } else {
                alert('Error al actualizar el registro'); // Mensaje de error
            }
        })
        .catch(error => console.error('Error al actualizar el registro:', error)); // Manejo de errores
}

// FUNCIÓN PARA CANCELAR LA EDICIÓN DE UN REGISTRO
function cancelEdit(button) {
    const row = button.closest('tr');
    const cells = row.querySelectorAll('.editable');

    cells.forEach(cell => {
        const input = cell.querySelector('input');
        cell.textContent = input.dataset.originalValue; // Restaura el valor original
    });

    toggleEditButtons(row, false); // Desactiva los botones de edición
}

// FUNCIÓN PARA CAMBIAR ENTRE MODO DE EDICIÓN Y MODO NORMAL
function toggleEditButtons(row, isEditing) {
    const editButton = row.querySelector('.btn-warning');
    const deleteButton = row.querySelector('.btn-danger');
    const saveButton = row.querySelector('.btn-success');
    const cancelButton = row.querySelector('.btn-secondary');

    if (isEditing) {
        editButton.classList.add('d-none'); // Oculta el botón de edición
        deleteButton.classList.add('d-none'); // Oculta el botón de eliminación
        saveButton.classList.remove('d-none'); // Muestra el botón de guardar
        cancelButton.classList.remove('d-none'); // Muestra el botón de cancelar
    } else {
        editButton.classList.remove('d-none'); // Muestra el botón de edición
        deleteButton.classList.remove('d-none'); // Muestra el botón de eliminación
        saveButton.classList.add('d-none'); // Oculta el botón de guardar
        cancelButton.classList.add('d-none'); // Oculta el botón de cancelar
    }
}
