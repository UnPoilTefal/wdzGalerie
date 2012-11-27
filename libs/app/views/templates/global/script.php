        <script src="http://code.jquery.com/jquery.js"></script>
        <script>window.jQuery || document.write('<script src="<?php echo base_url('js/global/jquery-1.8.2.min.js')?>"><\/script>')</script>

        <script src="<?php echo base_url('js/global/bootstrap.min.js')?>"></script>
        
        <script src="<?php echo base_url('js/global/main.js')?>"></script>
		<script src="<?php echo base_url('js/jquery.fullscreenslides.js')?>"></script>
		<script src="<?php echo base_url('js/coreGallery.js')?>"></script>
        <script>
        $(document).ready(function() {
            $("#cssSwitch li a").click(function() { 
                $("link.switchable").attr("href",$(this).attr('rel'));
                //$.cookie("css",$(this).attr('rel'), {expires: 30, path: '/'});
                $('body').hide().fadeIn(1250);
                return false;
            });
        });
        </script>
        <script>
            var _gaq=[['_setAccount','UA-XXXXX-X'],['_trackPageview']];
            (function(d,t){var g=d.createElement(t),s=d.getElementsByTagName(t)[0];
            g.src=('https:'==location.protocol?'//ssl':'//www')+'.google-analytics.com/ga.js';
            s.parentNode.insertBefore(g,s)}(document,'script'));
        </script>
