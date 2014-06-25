
<?php 

global $post;


$single_name = $post->post_type;
$single_name = str_replace('_post', '', $single_name);
$single_name = str_replace('_', '-', $single_name);

//echo "single:" . $single_name;

if($single_name == "board"){
  get_template_part('single','board');
}else if($single_name == "post"){
  get_template_part('single','post');
}else if($single_name == "press"){
  get_template_part('single','press');
}else if($single_name == "exhibition" || $single_name == "stipend" || $single_name == "appropriation" || $single_name == "award-winner"){
  get_template_part('single','post-type');
}else{
  get_template_part('single','default');
}


?>

