<div class="row">
    <div class="col-md-10 col-md-offset-1">
        <form action="<?php echo WEB_ROOT?>/admin/search.php" method="post">
            <?php echo csrf_token_tag(); ?>
            <div class="form-group">
                <label for="person">Person</label>
                <select name="person" id="person" class="form-control"> 
                    <?php 
                        foreach ($persons as $person) {
                            echo "<option value=\"".$person."\"";
                            if (isset($post->person)) {
                                if ($post->person == $person) { echo " selected";}
                            }
                            echo ">".$person."</option>";
                        }
                    ?>
                </select>
            </div>
            <div class="form-group">
                <label for="event_date">Date</label>
                <input type="date" name="event_date" id="event_date" class="form-control" value=""/> 
            </div>
            <div class="form-group">
                <label for="title">title</label>
                <input type="text" name="title" id="title"  maxlength="100" class="form-control" value=""/> 
            </div>
            <div class="form-group">
                <label for="description">Description</label>
                <textarea name="description" id="description" class="form-control" rows="10"></textarea>
            </div>
            <div class="form-group">
                <label for="author">Author</label>
                <input type="text" name="author" id="author" maxlength="30" class="form-control" value=""/> 
            </div>          
            <div class="form-group">
                <label for="tags">Tags</label>
                <input type="text" name="tags" id="tags" maxlength="300" class="form-control" value=""/> 
            </div>
            <button type="submit" name="submit" value="search" class="btn btn-primary">Submit</button>
            &nbsp;
            <a class="btn btn-default" href="<?php echo WEB_ROOT?>/admin/list_posts.php">Cancel</a>
        </form>
        <br />
    </div>
</div>
