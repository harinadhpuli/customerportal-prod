<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

                        <div class="app-page-title customBreadCrumbsTitle">
                            <div class="page-title-wrapper">
                                <div class="page-title-heading">
                                    <div class="page-title-icon breadcrumb-icon">
                                        <i class="metismenu-icon <?php echo $breadcrumbs['icon_class'] ?>" aria-hidden="true"></i>
                                     
                                    </div>
                                    <div><?php echo $breadcrumbs['title']  ?>
                                        <div class="page-title-subheading">
                                        <?php echo $breadcrumbs['helptext']  ?>
                                        </div>
                                    </div>
                                </div>


<?php if(isset($breadcrumbs['actions'])){  
        if(!empty($breadcrumbs['actions'])){ 
?>
                                <div class="page-title-actions">
                                <div class="d-inline-block dropdown">
                                    <button type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="btn-shadow dropdown-toggle btn btn-info">
                                        Actions
                                    </button>
                                    <div tabindex="-1" role="menu" aria-hidden="true" class="dropdown-menu dropdown-menu-right">
                                        <ul class="nav flex-column">
                                            <?php if(isset($breadcrumbs['actions']['add'])){  ?>
                                            <li class="nav-item">
                                                <a class="nav-link" href="<?php echo $breadcrumbs['actions']['add'] ?>">
                                                   <span>
                                                       Add
                                                    </span>
                                                </a>
                                            </li>
                                            <?php } ?>
                                            <?php if(isset($breadcrumbs['actions']['list'])){  ?>

                                            <li class="nav-item">
                                                <a class="nav-link" href="<?php echo $breadcrumbs['actions']['list'] ?>">
                                                    <span>
                                                        List
                                                    </span>
                                                </a>
                                            </li>
                                            <?php } ?>
                                        </ul>
                                    </div>
                                </div>
                                </div>
<?php } } ?>




                            </div>
                            
                        </div>    
                        <script>
                       // document.getElementById('dynamicPageTitle').innerHTML="Pro-Vigil Monitoring";
                        </script>
                    