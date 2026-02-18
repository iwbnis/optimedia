   <!--Blogs started-->
    
    <style>
        .blogs-list {
            position: relative;
            padding:2rem;
            margin:2rem;
            min-height:40vh;

            display: -ms-grid;
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            -webkit-box-align: center;
            -ms-flex-align: center;
            align-items: center;
            -ms-flex-line-pack: center;
            align-content: center;
            -webkit-box-pack: center;
            -ms-flex-pack: center;
            justify-content: center;
            grid-gap: 2rem;
            margin-bottom: 4rem;
        }
        
        @media only screen and (max-width: 1030px){
            .blogs-list {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media only screen and (max-width: 800px){
            .blogs-list {
                grid-template-columns: repeat(1, 1fr);
            }
        }

        .blogs-list .blog-item {
            position: relative;
            height: 100%;
            height: 35rem;
            overflow: hidden;
            border-radius: 0.25rem;
        }
        .blog-item figure {
            position: absolute;
            inset: 0;
            height: 100%;
        }
        .blog-item .blog-details {
            cursor: pointer;
            padding-inline: 1.5rem;
            padding-block: 2rem;
            position: absolute;
            width: 100%;
            bottom: 0;
            z-index: 1;
            background-image: -webkit-gradient(
                linear,
                left top,
                left bottom,
                from(rgba(0, 0, 0, 0.95)),
                to(transparent)
            );
            background-image: -o-linear-gradient(top, rgba(0, 0, 0, 0.95), transparent);
            background-image: linear-gradient(to bottom, rgba(0, 0, 0, 0.95), transparent);
            border-top-right-radius: 2rem;
            border-top-left-radius: 2rem;
        }

        .blog-item .blog-details h3 {
            font-size: 2.5rem;
            color: #fff;
            margin-bottom: 1rem;

            overflow: hidden; /* hide any content that exceeds the max-height */
            display: -webkit-box; /* use webkit prefix for Safari/Chrome */
            -webkit-line-clamp: 1; /* set the number of lines to be displayed */
            -webkit-box-orient: vertical; /* set the orientation of the box */
        }
        .blog-item .blog-details p {
            font-size: 2rem;
            color: #fff;
            margin-bottom: 2rem;

            white-space: nowrap;
            overflow: hidden;
            -o-text-overflow: ellipsis;
            text-overflow: ellipsis;
            max-width: 200ch;
        }

        .read-more-btn {
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
            display:block;
            width:max-content;
        }


        .btn-center {
            margin-inline: auto;
            margin-bottom: 2rem;
        }

        .blog-item .blog-details a:is(:hover, :focus, :focus-within) {
            background-color: #fff;
            color: #000;
        }

        .blog-item figure img {
            width: 100%;
            height: 100%;
            aspect-ratio: 16 / 9;
            -o-object-fit: cover;
            object-fit: cover;
        }
        .blogs-list-loading-container {
            z-index: 5;
            color:#000;
        }
        .blogs-list-loading-container .spinner-container div{
            background-color: rgba(0,0,0,0.8);
        }

        @media only screen and (max-width: 500px){
            .blog-item .blog-details h3 {
                font-size: 1.6rem;
                margin-bottom: 1rem;
            }
            .blog-item .blog-details p {
                font-size: 1.2rem;
                margin-bottom: 1rem;
            }
            .read-more-btn {
                font-size: 1rem;
            }
           
        }
       
    </style>
    <section class="blogs-list">
        <div class="loading-container blogs-list-loading-container">
            <div class="spinner-container ">
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
            <h6> Loading Blogs </h6>
        </div>

    </section>

    <a href="articles-page.php" target="_blank" class="read-more-btn btn-center">View All Articles</a>

    <script>
        async function getData(link) {
            const res = await fetch(link, {
                method: "GET",
            });

            const data = await res.json();
            return data.sort((a, b) => new Date(b.datecreate) - new Date(a.datecreate)); // sorted data
            // return data // simple data
        }

        async function init() {
            const blogs = await getData("whmcms_blogs.php");

            const blogsListContainer = document.querySelector(".blogs-list");
            
            // REMOVING LOADING
            const loadingContainer = document.querySelector(".blogs-list-loading-container");
            loadingContainer.remove();


            const blogItemHTML = `
                <article class="blog-item">
                    <figure>
                        <img src="%imageLink%" alt="" loading="lazy" />
                    </figure>

                    <section class="blog-details">
                        <h3>%heading%</h3>
                        <p>%content%</p>
                        <a href="%postLink%" target="_blank" class="read-more-btn">Read More</a>
                    </section>
                </article>
            `;

            let dummyPostImage =
                "https://images.unsplash.com/photo-1546074177-ffdda98d214f?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxzZWFyY2h8OXx8YmxvZ3xlbnwwfHwwfHx8MA%3D%3D&auto=format&fit=crop&w=500&q=60";

            function extractContentFromHTML(html) {
                const element = document.createElement('div')
                element.insertAdjacentHTML("beforeend",html)
                
                const h1 = element.querySelector('h1')
                if (h1)
		{
		h1.remove();
		}
                element.remove()

            
                return element.textContent
            }

            let postsToShow = 6
            blogs.slice(0, postsToShow).forEach((blog, i) => {
                let htmlString = blogItemHTML.replace(
                    "%imageLink%",
                    blog.coverimage || dummyPostImage
                );
                htmlString = htmlString.replace("%heading%", blog.title);
                htmlString = htmlString.replace("%postLink%", blog.alias);

                let textContent = extractContentFromHTML(blog.content)

                htmlString = htmlString.replace(
                    "%content%",
                    textContent ||
                        " Lorem ipsum dolor sit amet, consectetur adipisicing elit. Doloribus aspernatur dignissimos, commodi velit minima, deserunt voluptatibus, ad sed sunt quia tempora qui fugiat iste repudiandae voluptatum nostrum. Ad, quis labore?"
                );


                blogsListContainer.insertAdjacentHTML("beforeend", htmlString);
            });
        }
        
        init();
    </script>
    
    <!--Blogs ended-->
