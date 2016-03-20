<script type="text/javascript">
    $(document).ready(function () {
        console.log("home/js/index_js.php called");


        $(".doctor-list").owlCarousel({
            items: 3,
            autoplay: true,
            nav: false,
            lazyload: false,
            dots: true,
            margin: 30,
            responsive: {
                0: {
                    items: 1
                },
                400: {
                    items: 2
                },
                700: {
                    items: 3
                }
            }
        });
        
        $(".poli-list").owlCarousel({
            items: 4,
            autoplay: true,
            nav: false,
            lazyload: false,
            dots: true,
            margin: 30,
            responsive: {
                0: {
                    items: 1
                },
                400: {
                    items: 2
                },
                700: {
                    items: 3
                }
            }
        });
    });
</script>