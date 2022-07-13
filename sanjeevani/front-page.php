<?php get_header(); ?>

    <div class="welcome-section">
        <div class="welcome-banner">
            <picture>
                <source media="(max-width: 767px)" srcset="https://dummyimage.com/600x850/bdb7bd/0011ff&text=mobile+banner+welcome">
                <source media="(max-width: 1023px)" srcset="https://dummyimage.com/900x1000/666666/ffffff&text=tab+size">
                <img src="https://dummyimage.com/1400x820/666666/ffffff&text=pc+size">
            </picture>
            <div class="common-padding-wrap">
                <div class="welcome-content">
                    <div class="welcome-header">
                        <h1>Sanjeewanie</h1>
                        <h1>Ayurweda</h1>
                    </div>
                    <div class="welcome-para">
                        <p>
                            Lorem, ipsum dolor sit amet consectetur adipisicing elit. 
                            Culpa repellat distinctio atque fugit, corrupti id inventore 
                            magni sapiente, nesciunt velit ratione omnis laudantium voluptas 
                            facere ducimus incidunt cupiditate magnam vitae?
                        </p>
                    </div>
                    <div class="welcome-link">
                        <div class="round-div"> </div>
                        <div class="link">
                            <a href="">
                                <span>Buy Now</span>    
                                <svg width="20" height="20" aria-hidden="true">
                                    <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#rightarrow"></use>
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="croll-down-arrow">
                    <svg width="20" height="20" aria-hidden="true">
                        <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#down-arrow2"></use>
                    </svg>
                </div>
            </div>           
        </div>
    </div>
<!-- end sec1 -->
<!-- 
    <div class="welcome-banner">
        <picture>
            <source media="(max-width: 767px)" srcset="https://dummyimage.com/600x850/bdb7bd/0011ff&text=mobile+banner+welcome">
            <source media="(max-width: 1023px)" srcset="https://dummyimage.com/900x1000/666666/ffffff&text=tab+size">
            <img src="https://dummyimage.com/1400x820/666666/ffffff&text=pc+size">
        </picture>
    </div> -->

    <div class="slider-section">
        <div class="slider-wrapper">
            <div class="section-subheader">
                <span>Learn More</span>
            </div>
            <div class="section-header">
                <h2>Learn More About Us</h2>
            </div>
            <div id="readmore" class="owl-carousel owl-theme">
                <div class="item">
                    <a href="" class="video-image-link" data-fancybox>
                        <div class="slider-image">
                            <img src="https://dummyimage.com/600x400/bdbdbd/ffffff&text=video+player+bg+img+600+x+400">
                        </div>
                    
                        <div class="play-button-main">
                            <svg width="20" height="20" aria-hidden="true">
                                <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#play-main"></use>
                            </svg>
                        </div>
                    </a>
                    <div class="slider-header">
                        <span>testing header</span>
                    </div>
                    <div class="slider-description"> 
                        <p>testing Lorem ipsum dolor sit amet consectetur adipisicing elit. 
                            Repellendus omnis nulla voluptates 
                            modi hic unde voluptatum, suscipit consequuntur. Veritatis fugiat 
                            nisi enim ullam ipsum numquam, blanditiis a accusamus sapiente molestiae.</p>
                    </div>
                    <div class="play-video-link">
                        <div class="welcome-link">
                            <div class="round-div"> </div>
                            <div class="link">
                                <a href="" data-fancybox>
                                    <span>Buy Now</span>    
                                    <svg width="20" height="20" aria-hidden="true">
                                        <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#rightarrow"></use>
                                    </svg>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="item">
                    <a href="" class="video-image-link" data-fancybox>
                        <div class="slider-image">
                            <img src="https://dummyimage.com/600x400/bdbdbd/ffffff&text=video+player+bg+img+600+x+400">
                        </div>
                    
                        <div class="play-button-main">
                            <svg width="20" height="20" aria-hidden="true">
                                <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#play-main"></use>
                            </svg>
                        </div>
                    </a>
                    <div class="slider-header">
                        <span>testing header</span>
                    </div>
                    <div class="slider-description"> 
                        <p>testing Lorem ipsum dolor sit amet consectetur adipisicing elit. 
                            Repellendus omnis nulla voluptates 
                            modi hic unde voluptatum, suscipit consequuntur. Veritatis fugiat 
                            nisi enim ullam ipsum numquam, blanditiis a accusamus sapiente molestiae.</p>
                    </div>
                    <div class="play-video-link">
                        <div class="welcome-link">
                            <div class="round-div"> </div>
                            <div class="link">
                                <a href="" data-fancybox>
                                    <span>Buy Now</span>    
                                    <svg width="20" height="20" aria-hidden="true">
                                        <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#rightarrow"></use>
                                    </svg>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
<?php get_footer(); ?>