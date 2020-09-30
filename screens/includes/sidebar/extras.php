<?php if($count_extras > 0){ ?>
<hr>
<ul class="buyables m-b-25 list-unstyled <?=($lang_dir == "right" ? 'text-right':'')?>">
  <?php
  $i = 0;
  $total = 0;
  while($row_extras = $get_extras->fetch()){
    $id = $row_extras->id;
    $name = $row_extras->name;
    $price = $row_extras->price;
    $total += $price;
    $i++;
  ?>
  <li class="<?=($lang_dir == "right" ? 'text-right':'')?>">
    <label class="<?=($lang_dir == "right" ? 'text-right':'')?>">
    <input class="mb-2" style="width: 15px;height: 15px;" type="checkbox" name="proposal_extras[<?php echo $i; ?>]" value="<?php echo $id; ?>">
    <span class="js-express-delivery-text <?=($lang_dir == "right" ? 'text-right':'')?>">
    <?php echo $name; ?>
    <!-- This Is Extra, appears if denied by seller during the proposal setup. -->
    </span>
    <span class='price <?=($lang_dir == "right" ? 'text-right':'')?>'>
    <b class='currency'><?php echo $s_currency; ?><?php echo $price; ?></b>
    </span>
    </label>
  </li>
  <?php } ?>
</ul> 
<?php } ?>