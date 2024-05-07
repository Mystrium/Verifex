<script src="https://cdn.datatables.net/2.0.3/js/dataTables.js"></script>
<script> 
    $(document).ready(function() {
        $("[name='jsTable']").DataTable( {
            "language": {
                "lengthMenu": " _MENU_  записів на сторінку",
                "zeroRecords": "Нічого не знайденно",
                "info": "Сторінка _PAGE_ із _PAGES_ сторінок",
                "infoEmpty": "Поки що немає записів",
                "search": "Пошук",
                "infoFiltered": "(Фільтровано з _MAX_ записів)",
                "emptyTable" : "Немає записів"
            }
        } );
    } ); 
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.12.6/js/standalone/selectize.min.js" integrity="sha256-+C0A5Ilqmu4QcSPxrlGpaZxJ04VjsRjKu+G82kl5UJk=" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
<script>$('.search-drop').select2();</script>
<script>
    window.toedit = function(self, val, edit_btn){
        if(self.value != val)
            document.getElementById(edit_btn).disabled = false;
        else
            document.getElementById(edit_btn).disabled = true;
    }

    window.addEventListener('DOMContentLoaded', event => {
        const sidebarToggle = document.body.querySelector('#sidebarToggle');
        if (sidebarToggle) {
            sidebarToggle.addEventListener('click', event => {
                event.preventDefault();
                document.body.classList.toggle('sb-sidenav-toggled');
                localStorage.setItem('sb|sidebar-toggle', document.body.classList.contains('sb-sidenav-toggled'));
            });
        }
    });
</script>
<script>$('.alert').fadeOut(7000);</script>