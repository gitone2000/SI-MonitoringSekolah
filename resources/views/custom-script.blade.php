<script>
    document.addEventListener('DOMContentLoaded', function () {
        document.getElementById('addFormButton').addEventListener('click', function () {
            // Temukan form yang ada dan klon
            var formToClone = document.querySelector('.fields-group');
            var clonedForm = formToClone.cloneNode(true);

            // Reset nilai input di form yang diklon
            Array.from(clonedForm.querySelectorAll('input, select, textarea')).forEach((input) => {
                input.value = '';
                if (input.type === 'select-multiple') {
                    Array.from(input.options).forEach((option) => {
                        option.selected = false;
                    });
                }
            });

            // Tambahkan form yang diklon ke container form
            formToClone.parentNode.appendChild(clonedForm);
        });
    });
</script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        document.getElementById('addFormButton').addEventListener('click', function () {
            // Temukan form yang ada dan klon
            var formToClone = document.querySelector('.fields-group');
            var clonedForm = formToClone.cloneNode(true);

            // Reset nilai input di form yang diklon dan buat ID unik
            Array.from(clonedForm.querySelectorAll('input, select, textarea')).forEach((input, index) => {
                input.value = '';
                if (input.type === 'select-multiple') {
                    Array.from(input.options).forEach((option) => {
                        option.selected = false;
                    });
                }
                // Buat ID unik untuk setiap elemen
                if (input.id) {
                    input.id = input.id + '_' + (new Date().getTime()) + '_' + index;
                }
            });

            // Tambahkan form yang diklon ke container form
            document.getElementById('form-container').appendChild(clonedForm);

            // Inisialisasi ulang plugin atau event listeners jika diperlukan
            // Contoh untuk select2:
            $(clonedForm).find('select').select2();
        });
    });
</script>

