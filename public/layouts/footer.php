        <div id="footer" class="row">
            <div class="col-md-12">
                Copyright <?php echo date("Y");?>, Datagold
            </div>
        </div>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="<?php echo WEB_ROOT?>/js/bootstrap.min.js"></script>
    </body>
</html>
<?php if(isset($connection))  {mysqli_close($connection);} ?>