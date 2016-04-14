<script type="text/javascript">
    var eventRemoveListItem = function (e) {
        e.preventDefault();
        $(this).parents('a').remove();
    };
    
    $(document).ready(function () {
        $(".btn-remove-list").click(eventRemoveListItem);
    });
</script>