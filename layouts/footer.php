<!-- Bootstrap CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/css/bootstrap.min.css" integrity="...">
<!-- Font Awesome CSS -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" integrity="...">

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/js/bootstrap.bundle.min.js" integrity="..."></script>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    // Handle hamburger icon click event
    $('#toggleBtn').click(function() {
    if ($(window).width() > 767) {
        $('#UserContainer').toggleClass('d-none');
        $('#taskContainer').toggleClass('col-md-9 col-12');
        
    }
    else{
      $('#UserContainer').toggleClass('position-absolute');
      if ($('#UserContainer').hasClass('position-absolute')) {
        $('#UserContainer').css({
          'display': 'block',
          'position': 'absolute',
          'top': '0',
          'right': '0',
          'bottom': '0',
          'left': '0',
          'background-color': 'rgba(255, 255, 255, 1)',
          'min-width' : '250px',
          'z-index': '2'
        });
        $(".task-overlay").css({
          'display' : 'block'
        });
      } 
      else {
        $('#UserContainer').css({
          'display': 'none',
          'position': '',
          'top': '',
          'right': '',
          'bottom': '',
          'left': ''
        });
      }
    }
    });
    $(".task-overlay").click(function() {
      $('#UserContainer').toggleClass('position-absolute');
      $('#UserContainer').css({
          'display': 'none',
          'position': '',
          'top': '',
          'right': '',
          'bottom': '',
          'left': ''
        });
      $(".task-overlay").css({
        'display' : 'none'
      });
    });
    function toggleAccordion(button) {
        const accordionItem = button.closest('.accordion-item');
        const collapse = accordionItem.querySelector('.accordion-collapse');
        
        if (collapse.classList.contains('show')) {
            button.querySelector('i').classList.replace('fa-minus', 'fa-plus');
        } else {
            button.querySelector('i').classList.replace('fa-plus', 'fa-minus');
        }
    
        collapse.classList.toggle('show');
    }


</script>
    </body>
</html>