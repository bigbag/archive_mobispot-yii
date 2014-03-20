<script src="/themes/mobispot/foundation/js/foundation.min.js"></script>

<script src="/themes/mobispot/js/general.js"></script>

<script src="/themes/mobispot/angular/modules/sortable/sortable.js"></script>
<script src="/themes/mobispot/angular/app/app.js"></script>
<script src="/themes/mobispot/angular/app/controllers/user.js"></script>
<script src="/themes/mobispot/angular/app/controllers/spot.js"></script>
<script src="/themes/corp/angular/app/controllers/payment.js"></script>
<script src="/themes/mobispot/angular/app/services.js"></script>
<script src="/themes/mobispot/js/ga.js"></script>
<script type="text/javascript"> 
    $('textarea').autosize();
</script>
<script type="text/javascript">
    if (window.location.hash == '#_=_') {
        window.location.hash = ''; // for older browsers, leaves a # behind
        history.pushState('', document.title, window.location.pathname); // nice and clean
        e.preventDefault(); // no page reload
    }
</script>