        <div class="row">
            <div class="col-xs-12" style="height:20px;"></div>
        </div>
        <div id="footer" class="row">
            <div class="col-md-12">
                Copyright <?php echo date("Y");?>, Datagold
            </div>
        </div>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
    <script src="<?php echo WEB_ROOT?>/js/bootstrap.min.js"></script>
    <script src="<?php echo WEB_ROOT?>/js/global.js"></script>

    </body>
</html>
<?php if(isset($connection))  {mysqli_close($connection);} ?>