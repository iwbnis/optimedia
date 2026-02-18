    <style>
     .blogs-container {
        max-width: 120rem;
        margin-inline: auto;
        position:relative;
        min-height:40vh;
        color: #000;
    }

    .blogs-container .blog {
        padding-inline: 2rem;
        padding-block: 4rem;
        border: 1px solid #000;
        border-radius:1rem;
        margin-bottom: 2rem;
        box-shadow: 1px 3px 5px rgba(0,0,0,0.2)
    }
    .blog .blog-heading {
        text-align: center;
        font-size: 3rem;
        margin-bottom: 1rem;
    }

    .blog .blog-stats {
        list-style: initial;
        font-size: 1.8rem;
        margin-bottom: 1rem;
        text-align: center;

        display: -webkit-box;

        display: -ms-flexbox;

        display: flex;
        -webkit-box-align: center;
        -ms-flex-align: center;
        align-items: center;
        -webkit-box-pack: center;
        -ms-flex-pack: center;
        justify-content: center;
        gap: 4rem;
    }

    .blog .blog-image {
        height: 100%;
        max-width: 60vw;
        max-height: 60rem;
        overflow: hidden;
        margin-bottom: 2rem;
        margin-inline:auto;
    }
    .blog .blog-image img {
        width: 100%;
        height: 100%;
        aspect-ratio: 16 / 9;
        -o-object-fit: cover;
        object-fit: cover;
    }

    .blog .blog-content {
        font-size: 2rem;
        margin-bottom: 2rem;

        overflow: hidden; /* hide any content that exceeds the max-height */
        display: -webkit-box; /* use webkit prefix for Safari/Chrome */
        -webkit-line-clamp: 5; /* set the number of lines to be displayed */
        -webkit-box-orient: vertical; /* set the orientation of the box */
    }
    .blog .blog-content h1 {
        margin-bottom: 1rem;
    }

    .blog .blog-read-more {
        text-decoration: none;
        border: 1px solid;
        border-radius: 0.25rem;
        background-color: #000;
        color: #fff;
        font-size: 1.4rem;
        cursor: pointer;
        padding: 0.6rem 1.5rem;
        -webkit-transition: 0.25s;
        -o-transition: 0.25s;
        transition: 0.25s;
    }

    .blog .blog-read-more:is(:hover, :focus, :focus-within) {
        background-color: #fff;
        color: #000;
    }

      /* LOADING START */
        
        .loading-container {
            z-index:5;
            position:absolute;
            top: 50%;
            left:50%;
            transform:translate(-50%,-50%);
            width: 120px;
            height: 120px;
            display: inline-block;
            background: none;
            color:#000;
            text-align:center;
        }

        .spinner-container {
            width: 100%;
            height: 100%;
            position: relative;
            transform: translateZ(0) scale(1);
            backface-visibility: hidden;
            transform-origin: 0 0; /* see note above */
        }
        .spinner-container {
            transform: translateX(-30px);
        }
      
        .spinner-container div {
            box-sizing: content-box;
            left: 50%;
            top: 50%;
            position: absolute;
            animation: spin linear 1s infinite;
            background: #000 !important;
            width: 8px;
            height: 8px;
            border-radius: 6px / 6px;
            transform-origin: 30px;
        }

        @keyframes spin {
            0% {
                opacity: 1;
            }
            100% {
                opacity: 0;
            }
        }

        .spinner-container div:nth-child(1) {
            transform: rotate(0deg);
            animation-delay: -0.9166666666666666s;
        }
        .spinner-container div:nth-child(2) {
            transform: rotate(30deg);
            animation-delay: -0.8333333333333334s;
        }
        .spinner-container div:nth-child(3) {
            transform: rotate(60deg);
            animation-delay: -0.75s;
        }
        .spinner-container div:nth-child(4) {
            transform: rotate(90deg);
            animation-delay: -0.6666666666666666s;
        }
        .spinner-container div:nth-child(5) {
            transform: rotate(120deg);
            animation-delay: -0.5833333333333334s;
        }
        .spinner-container div:nth-child(6) {
            transform: rotate(150deg);
            animation-delay: -0.5s;
            
        }
        .spinner-container div:nth-child(7) {
            transform: rotate(180deg);
            animation-delay: -0.4166666666666667s;
            
        }
        .spinner-container div:nth-child(8) {
            transform: rotate(210deg);
            animation-delay: -0.3333333333333333s;
            
        }
        .spinner-container div:nth-child(9) {
            transform: rotate(240deg);
            animation-delay: -0.25s;
            
        }
        .spinner-container div:nth-child(10) {
            transform: rotate(270deg);
            animation-delay: -0.16666666666666666s;
            
        }
        .spinner-container div:nth-child(11) {
            transform: rotate(300deg);
            animation-delay: -0.08333333333333333s;
            
        }
        .spinner-container div:nth-child(12) {
            transform: rotate(330deg);
            animation-delay: 0s;
            
        }
        /* LOADING END */
        </style>

        <section class="blogs-container">
            <div class="loading-container blogs-loading-container">
                <div class="spinner-container">
                    <div></div>
                    <div></div>
                    <div></div>
                    <div></div>
                    <div></div>
                    <div></div>
                    <div></div>
                    <div></div>
                    <div></div>
                    <div></div>
                    <div></div>
                    <div></div>
                </div>
                <h6>Loading Blogs</h6>
            </div>
        </section>

<script>
  async function getData(link) {
        const res = await fetch(link, {
            method: "GET",
        });

        const data = await res.json();
        return data.sort((a, b) => new Date(b.datecreate) - new Date(a.datecreate));
    }

    function extractContentFromHTML(html) {
        const element = document.createElement('div')
        element.insertAdjacentHTML("beforeend",html)
        
        const h1 = element.querySelector('h1')
        h1?.remove?.();

        element?.remove?.()

    
        return element.textContent
    }

    async function init() {
        const blogs = await getData("/whmcms_blogs.php");

        // REMOVING LOADING
        const loadingContainer = document.querySelector(".blogs-loading-container");
        loadingContainer.remove();

        const blogsListContainer = document.querySelector(".blogs-container");

        const blogItemHTML = `
                <article class="blog" id="blog-%blogID%">
                    <h2 class="blog-heading">%blogHeading%</h2>
                    <ul class="blog-stats">
                        <li class="blog-date">%blogDate%</li>
                        <li class="blog-category"></li>
                    </ul>

                    <figure class="blog-image">
                        <img src="%imageLink%" alt="" />
                    </figure>

                    <p class="blog-content"></p>

                    <a href="%postLink%" class="blog-read-more" target="_blank">Read More</a>
                </article>
            `;

        let dummyPostImage =
            "https://images.unsplash.com/photo-1546074177-ffdda98d214f?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxzZWFyY2h8OXx8YmxvZ3xlbnwwfHwwfHx8MA%3D%3D&auto=format&fit=crop&w=500&q=60";

        const blogsToShow = 6;

        blogs.forEach((blog, i) => {
            let htmlString = blogItemHTML.replace("%imageLink%", blog.coverimage || dummyPostImage);
            htmlString = htmlString.replace("%blogID%", blog.pageid);
            htmlString = htmlString.replace("%blogHeading%", blog.title);
            htmlString = htmlString.replace("%postLink%", blog.alias);

            htmlString = htmlString.replace(
                "%blogDate%",
                new Date(blog.datecreate).toLocaleDateString("en-US", {
                    weekday: "long",
                    year: "numeric",
                    month: "long",
                    day: "numeric",
                })
            );

            blogsListContainer.insertAdjacentHTML("beforeend", htmlString);

            const addedBlog = blogsListContainer.querySelector('#blog-' + blog.pageid);
            addedBlog
                .querySelector(".blog-category")
                .insertAdjacentHTML("beforeend", blog.metakeywords);

              
            addedBlog.querySelector(".blog-content").insertAdjacentHTML("beforeend", extractContentFromHTML(blog.content));
        });


    }

    init()
</script>