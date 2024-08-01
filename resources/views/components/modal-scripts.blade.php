<script>
    function confirmDelete(userId) {
     Swal.fire({
         title: 'Are you sure?',
         text: 'Do you want to delete this user?',
         icon: 'warning',
         showCancelButton: true,
         confirmButtonColor: '#28a745',
         cancelButtonColor: '#d33',
         confirmButtonText: 'Yes, delete it',
         cancelButtonText: 'No, cancel'
     }).then((result) => {
         if (result.isConfirmed) {
             // If the user clicks "Yes, delete it," submit the form
             document.forms['deleteForm_' + userId].submit();
         }
     });
 }
 </script>
 <script>
  $(document).ready(function () {
     $('.show-user-details').on('click', function (e) {
         e.preventDefault();

         var userId = $(this).data('user-id');

         $.ajax({
             url: "{{ route('users.show', ':id') }}".replace(':id', userId),
             type: 'GET',
             success: function (data) {
                 $('#userDetailsModalBody').html(data);
                 $('#userDetailsModal').modal('show');
             },
             error: function (error) {
                 console.log(error);
             }
         });
     });
 });

 </script>
 <script>
  $(document).ready(function () {
     $('.show-role-details').on('click', function (e) {
         e.preventDefault();

         var roleId = $(this).data('role-id');

         $.ajax({
             url: "{{ route('roles.show', ':id') }}".replace(':id', roleId),
             type: 'GET',
             success: function (data) {
                 $('#roleDetailsModalBody').html(data);
                 $('#roleDetailsModal').modal('show');
             },
             error: function (error) {
                 console.log(error);
             }
         });
     });
 });

 </script>
 <script>
  $(document).ready(function () {
     $('.show-obituary-details').on('click', function (e) {
         e.preventDefault();

         var obituaryId = $(this).data('obituary-id');

         $.ajax({
             url: "{{ route('obituaries.show', ':id') }}".replace(':id', obituaryId),
             type: 'GET',
             success: function (data) {
                 $('#obituaryDetailsModalBody').html(data);
                 $('#obituaryDetailsModal').modal('show');
             },
             error: function (error) {
                 console.log(error);
             }
         });
     });
 });
 </script>
 <script>
  $(document).ready(function () {
     $('.show-rememberence-details').on('click', function (e) {
         e.preventDefault();

         var rememberenceId = $(this).data('rememberence-id');

         $.ajax({
             url: "{{ route('rememberences.show', ':id') }}".replace(':id', rememberenceId),
             type: 'GET',
             success: function (data) {
                 $('#rememberenceDetailsModalBody').html(data);
                 $('#rememberenceDetailsModal').modal('show');
             },
             error: function (error) {
                 console.log(error);
             }
         });
     });
 });
 </script>
 <script>
  $(document).ready(function () {
     $('.show-news-details').on('click', function (e) {
         e.preventDefault();

         var newsId = $(this).data('news-id');

         $.ajax({
             url: "{{ route('newses.show', ':id') }}".replace(':id', newsId),
             type: 'GET',
             success: function (data) {
                 $('#newsDetailsModalBody').html(data);
                 $('#newsDetailsModal').modal('show');
             },
             error: function (error) {
                 console.log(error);
             }
         });
     });
 });
 </script>
 <script>
    function confirmDeleteRole(roleId) {
     Swal.fire({
         title: 'Are you sure?',
         text: 'Do you want to delete this role?',
         icon: 'warning',
         showCancelButton: true,
         confirmButtonColor: '#28a745',
         cancelButtonColor: '#d33',
         confirmButtonText: 'Yes, delete it',
         cancelButtonText: 'No, cancel'
     }).then((result) => {
         if (result.isConfirmed) {
             // If the user clicks "Yes, delete it," submit the form
             document.forms['deleteForm_' + roleId].submit();
         }
     });
 }
 </script>
 <script>
    function confirmDeleteSite(siteId) {
     Swal.fire({
         title: 'Are you sure?',
         text: 'Do you want to delete this site?',
         icon: 'warning',
         showCancelButton: true,
         confirmButtonColor: '#28a745',
         cancelButtonColor: '#d33',
         confirmButtonText: 'Yes, delete it',
         cancelButtonText: 'No, cancel'
     }).then((result) => {
         if (result.isConfirmed) {
             // If the user clicks "Yes, delete it," submit the form
             document.forms['deleteForm_' + siteId].submit();
         }
     });
 }
 </script>
 <script>
    function confirmDeleteCategory(categoryId) {
     Swal.fire({
         title: 'Are you sure?',
         text: 'Do you want to delete this category?',
         icon: 'warning',
         showCancelButton: true,
         confirmButtonColor: '#28a745',
         cancelButtonColor: '#d33',
         confirmButtonText: 'Yes, delete it',
         cancelButtonText: 'No, cancel'
     }).then((result) => {
         if (result.isConfirmed) {
             // If the user clicks "Yes, delete it," submit the form
             document.forms['deleteForm_' + categoryId].submit();
         }
     });
 }
 </script>
 <script>
  $(document).ready(function () {
     $('.show-advertisement-details').on('click', function (e) {
         e.preventDefault();

         var advertisementId = $(this).data('advertisement-id');

         $.ajax({
             url: "{{ route('advertisements.show', ':id') }}".replace(':id', advertisementId),
             type: 'GET',
             success: function (data) {
                 $('#advertisementDetailsModalBody').html(data);
                 $('#advertisementDetailsModal').modal('show');
             },
             error: function (error) {
                 console.log(error);
             }
         });
     });
 });
 </script>
 <script>
    function confirmDeleteAdvertisement(advertisementId) {
     Swal.fire({
         title: 'Are you sure?',
         text: 'Do you want to delete this advertisement?',
         icon: 'warning',
         showCancelButton: true,
         confirmButtonColor: '#28a745',
         cancelButtonColor: '#d33',
         confirmButtonText: 'Yes, delete it',
         cancelButtonText: 'No, cancel'
     }).then((result) => {
         if (result.isConfirmed) {
 document.forms['deleteForm_' + advertisementId].submit();
 }
     });
 }
    function confirmDeleteObituary(obituaryId) {
     Swal.fire({
         title: 'Are you sure?',
         text: 'Do you want to delete this obituary?',
         icon: 'warning',
         showCancelButton: true,
         confirmButtonColor: '#28a745',
         cancelButtonColor: '#d33',
         confirmButtonText: 'Yes, delete it',
         cancelButtonText: 'No, cancel'
     }).then((result) => {
         if (result.isConfirmed) {
             // If the user clicks "Yes, delete it," submit the form
             document.forms['deleteForm_' + obituaryId].submit();
         }
     });
 }
 </script>
 <script>
    function confirmDeleteRememberence(rememberenceId) {
     Swal.fire({
         title: 'Are you sure?',
         text: 'Do you want to delete this rememberence?',
         icon: 'warning',
         showCancelButton: true,
         confirmButtonColor: '#28a745',
         cancelButtonColor: '#d33',
         confirmButtonText: 'Yes, delete it',
         cancelButtonText: 'No, cancel'
     }).then((result) => {
         if (result.isConfirmed) {
             // If the user clicks "Yes, delete it," submit the form
             document.forms['deleteForm_' + rememberenceId].submit();

         }
     });
 }
 </script>
 <script>
    function confirmDeleteNews(newsId) {
     Swal.fire({
         title: 'Are you sure?',
         text: 'Do you want to delete this news?',
         icon: 'warning',
         showCancelButton: true,
         confirmButtonColor: '#28a745',
         cancelButtonColor: '#d33',
         confirmButtonText: 'Yes, delete it',
         cancelButtonText: 'No, cancel'
     }).then((result) => {
         if (result.isConfirmed) {
             // If the user clicks "Yes, delete it," submit the form
             document.forms['deleteForm_' + newsId].submit();

         }
     });
 }
 </script>
