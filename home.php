
<style>
    .carousel-item>img{
        object-fit:fill !important;
    }
    #carouselExampleControls .carousel-inner{
        height:280px !important;
    }
    #carouselExampleSLIDE .carousel-inner{
        height:80vh !important;
    }
    @media (max-width: 767px) {
  #carouselExampleSLIDE .carousel-inner {
    height: 30vh !important;
  }
}
@media (min-width: 768px) and (max-width: 1024px) {
  #carouselExampleSLIDE .carousel-inner {
    height: 40vh !important;
  }
}
    .padin-0{
        padding: 0px !important;
    }

    .fonthead{
        font-family: 'Arial', sans-serif;
      font-size: 2rem;
      font-weight: bold;
      color: #000;
      text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);
    }
    .mt-5px{
        margin-top: 5px !important;
    }

    .glasscard{
        padding: 20px 10px 20px 10px !important;
background: rgba(240, 79, 152, 0.15);
border-radius: 16px;
box-shadow: 0 4px 30px rgba(0, 0, 0, 0.1);
backdrop-filter: blur(8.6px);
-webkit-backdrop-filter: blur(8.6px);
    }
    .background-div {
      width: 100%; 
      padding-top:100px;
      height: auto; 
      background-image: url('./uploads/banner/banner1.jpg'); 
      background-size: cover;
      background-position: center;
      background-repeat: no-repeat;
    }
    .bg-card1{
        width: 100%;
        border-radius:16px !important;
      background-image: url('./uploads/card/card1.webp');
      background-size: cover;
      background-position: center;
      background-repeat: no-repeat;
      backdrop-filter: blur(2.6px);
      height: 50vh !important;
    }

    .bg-card2{
        width: 100%;
        border-radius:16px !important;
      background-image: url('./uploads/card/card2.webp');
      background-size: cover;
      background-position: center;
      background-repeat: no-repeat;
      backdrop-filter: blur(2.6px);
      height: 50vh !important;
    }

    .marginBottom{
        margin: 50px 15px 50px 15px !important;
    }
</style>
<?php 
$brands = isset($_GET['b']) ? json_decode(urldecode($_GET['b'])) : array();
?>

<!-- Hero Section -->
<section class=" h-100 padin-0 mt-5">
    <div class="container-fluid">
        <div class="row padin-0">
                <div class="col-md-12 h-100 padin-0">
                    <div id="carouselExampleSLIDE" class="carousel slide bg-dark" data-ride="carousel">
                        <div class="carousel-inner">
                            <?php 
                                $upload_path = "uploads/banner";
                                if(is_dir(base_app.$upload_path)): 
                                $file= scandir(base_app.$upload_path);
                                $_i = 0;
                                    foreach($file as $img):
                                        if(in_array($img,array('.','..')))
                                            continue;
                                $_i++;
                                    
                            ?>
                            <div class="carousel-item h-100 <?php echo $_i == 1 ? "active" : '' ?>">
                                <img src="<?php echo validate_image($upload_path.'/'.$img) ?>" class="d-block w-100  h-100" alt="<?php echo $img ?>">
                            </div>
                            <?php endforeach; ?>
                            <?php endif; ?>
                        </div>
                        <button class="carousel-control-prev" type="button" data-target="#carouselExampleSLIDE" data-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Previous</span>
                        </button>
                        <button class="carousel-control-next" type="button" data-target="#carouselExampleSLIDE" data-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Next</span>
                        </button>
                        </div>
                    </div>
                </div>
        </div>
    </div>
</section>

<!-- Banner -->
<section class=" h-100  pt-2">
 <div class="container-fluid text-center glasscard p-2">
    <h1 class="fonthead "> RG Garments. </h1>
 </div>
</section>

<!-- Brand section  -->
<section class="py-0 mt-5 shadow-5" id="smothBrand">
    <div class="container bg-gradient mt-3 p-4 rounded">
        <div class="glasscard p-4">
            <div class="p-4">
                <h3><b>Brands</b></h3>
                <p class="pt-3">
                    "Discover a curated selection of premium brands, tailored to elevate your style."
                </p>
            </div>
            <hr>
            <div class="row mt-3">
                <div class="p-4 col-lg-2 py-1 border-right text-sm position-sticky">
                    <h5>Top Brands</h5> 
                    <ul class="list-group bg-transparent">
                        <a href="" class="list-group-item list-group-item-action bg-transparent">
                            <div class="icheck-primary d-inline">
                                <input type="checkbox" id="brandAll" >
                                <label for="brandAll">
                                    All
                                </label>
                            </div>
                        </a>
                        <?php 
                        $qry = $conn->query("SELECT * FROM brands where status =1 order by name asc");
                        while($row=$qry->fetch_assoc()):
                        ?>
                        <li class="list-group-item list-group-item-action bg-transparent">
                            <div class="icheck-primary d-inline">
                                <input type="checkbox" id="brand-item-<?php echo $row['id'] ?>" <?php echo in_array($row['id'],$brands) ? "checked" : "" ?> class="brand-item" value="<?php echo $row['id'] ?>">
                                <label for="brand-item-<?php echo $row['id'] ?>">
                                        <?php echo $row['name'] ?>
                                </label>
                            </div>
                        </li>
                        <?php endwhile; ?>
                    </ul>
                </div>
                <div class="col-lg-10 py-1">
                    <div class="container p-2 px-lg-5 ">
                        <div class="row gx-4 gx-lg-4 row-cols-md-3 row-cols-xl-4 ">
                            <?php 
                                $where = "";
                                if(count($brands)>0)
                                $where = " and p.brand_id in (".implode(",",$brands).") " ;
                                $products = $conn->query("SELECT p.*,b.name as bname,c.category FROM `products` p inner join brands b on p.brand_id = b.id inner join categories c on p.category_id = c.id where p.status = 1 {$where} order by rand() ");
                                while($row = $products->fetch_assoc()):
                                    $upload_path = base_app.'/uploads/product_'.$row['id'];
                                    $img = "";
                                    if(is_dir($upload_path)){
                                        $fileO = scandir($upload_path);
                                        if(isset($fileO[2]))
                                            $img = "uploads/product_".$row['id']."/".$fileO[2];
                                        // var_dump($fileO);
                                    }
                                    foreach($row as $k=> $v){
                                        $row[$k] = trim(stripslashes($v));
                                    }
                                    $inventory = $conn->query("SELECT distinct(`price`) FROM inventory where product_id = ".$row['id']." order by `price` asc");
                                    $inv = array();
                                    while($ir = $inventory->fetch_assoc()){
                                        $inv[] = format_num($ir['price']);
                                    }
                                    $price = '';
                                    if(isset($inv[0]))
                                    $price .= $inv[0];
                                    if(count($inv) > 1){
                                    $price .= " ~ ".$inv[count($inv) - 1];

                                    }
                            ?>
                            <div class="col mb-5">
                                <a class="card product-item text-reset text-decoration-none" href=".?p=view_product&id=<?php echo md5($row['id']) ?>">
                                    <!-- Product image-->
                                    <div class="overflow-hidden shadow product-holder">
                                    <img class="card-img-top w-100 product-cover" src="<?php echo validate_image($img) ?>" alt="..." />
                                    </div>
                                    <!-- Product details-->
                                    <div class="card-body p-4">
                                        <div class="">
                                            <!-- Product name-->
                                            <h5 class="fw-bolder"><?php echo $row['name'] ?></h5>
                                            <!-- Product price-->
                                                <span><b class="text-muted">Price: </b><?php echo $price ?></span>
                                        </div>
                                        <p class="m-0"><small><span class="text-muted">Brand:</span> <?php echo $row['bname'] ?></small></p>
                                        <p class="m-0"><small><span class="text-muted">Category:</span> <?php echo $row['category'] ?></small></p>
                                    </div>
                                </a>
                            </div>
                            <?php endwhile; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Cards 2 -->
<section class="marginBottom mt-5">
    <div class="container-fluid bacground-div">
        <div class="container">
            <div class="row">
                <!-- Card 1  -->
                <div class="col-lg-6 col-md-6 col-sm-12">
                    <div class="card bg-card1">
                        <div class="card-body">
                            <p class="mt-2"><small>MEGA OFFER</small></p>
                            <div class="row">
                                <div class="col-md-5">
                                    <h2 class="fonthead text-white mt-5 glasscard">Get 65% Offer <br>& Make New <br> Fusion.</h2>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Card 2  -->
                <div class="col-lg-6 col-md-6 col-sm-12">
                    <div class="card bg-card2">
                        <div class="card-body">
                            <p class="mt-2"><small>NEW STYLE</small></p>
                            <div class="row">
                                <div class="col-md-5">
                                    <h2 class="fonthead text-white mt-5 glasscard">Make Your New Style <br> with US!</h2>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


<!-- Category section  -->
<section class="shadow-5 mb-5" id="catSection">
    <div class="container bg-gradient mt-3 p-4">
        <div class="glasscard p-4">
            <div class="row">
                <div class="col-lg-9 col-md-9 col-sm-12">
                    <div class="p-4">
                        <h3><b>Categories</b></h3>
                        <p class="pt-3">"Explore our curated categories for every style and occasion, ensuring you find the perfect pieces to elevate your wardrobe."</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-12">
                    <div class="p-4 d-flex justify-content-end">
                        <a class="btn bg-gradient-pink" href="./?p=view_categories">View All Categories</a>
                    </div>
            </div>
            <hr>
            <div class="text-center pt-4">
                <h5><b>Our Top Categories</b></h5>
            </div>
            <div class="row p-3  text-center">
                <?php
                    $cat_qry = $conn->query("SELECT * FROM categories where status = 1  limit 4");
                    $count_cats =$conn->query("SELECT * FROM categories where status = 1 ")->num_rows;
                    while($crow = $cat_qry->fetch_assoc()):
                ?>
                    <!-- card 1  -->
                    <div class="col-lg-3 p-2">
                        <div class="card glasscard">
                            <div class="card-body">
                                
                                <div class="">
                                <a class="btn bg-gradient" aria-current="page" href="./?p=products&c=<?php echo md5($crow['id']) ?>"><?php echo $crow['category'] ?></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php endwhile; ?>
            </div>
    </div>
</section>





<!-- scripts  -->
<script>
    function _filter(){
        var brands = []
            $('.brand-item:checked').each(function(){
                brands.push($(this).val())
            })
        _b = JSON.stringify(brands)
        var checked = $('.brand-item:checked').length
        var total = $('.brand-item').length
        if(checked == total)
            location.href="./?";
        else
            location.href="./?b="+encodeURI(_b);
    }
    function check_filter(){
        var checked = $('.brand-item:checked').length
        var total = $('.brand-item').length
        if(checked == total){
            $('#brandAll').attr('checked',true)
        }else{
            $('#brandAll').attr('checked',false)
        }
        if('<?php echo isset($_GET['b']) ?>' == '')
            $('#brandAll,.brand-item').attr('checked',true)
    }
    $(function(){
        check_filter()
        $('#brandAll').change(function(){
            if($(this).is(':checked') == true){
                $('.brand-item').attr('checked',true)
            }else{
                $('.brand-item').attr('checked',false)
            }
            _filter()
        })
        $('.brand-item').change(function(){
            _filter()
        })
    })


  // Function to scroll to a specific element
  function scrollToElement(elementId) {
    var element = document.getElementById(elementId);
    if (element) {
      element.scrollIntoView({ behavior: 'smooth' });
    }
  }
  window.onload = function() {
    scrollToElement('smothBrand');
  };
</script>