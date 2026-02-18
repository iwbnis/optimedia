<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="ie=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />

        <!--build:css-->
        <link rel="stylesheet" href="{$WEB_ROOT}/templates/{$template}/customfiles/assets/css/main.css"/>
        <!-- endbuild -->
        <!---<link rel="stylesheet" href="{$WEB_ROOT}/templates/{$template}/css/custom.css"/>-->

    <style>
        .categoryList-dropdown-container {
            min-height: 50vh;
        }
        .categoryList-dropdown {
            position: relative;
            display: inline-block;
            width: 100%;
        }

        .categoryList-search {
            padding: 5px;
            width: 100%;
        }

        #categoryList {
        /* display: none; */
            position: absolute;
            background-color: #f9f9f9;
            box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);
            list-style-type: none;
            padding: 0;
            margin: 0;
            width: 100%;
            z-index: 1;
            max-height: 200px; /* Adjust the maximum height as needed */
            overflow-y: auto; /* Enable vertical scrollbar when content exceeds max height */
        }

        #categoryList li {
            padding: 10px;
            cursor: pointer;
        }

        #categoryList li:hover {
            background-color: #ddd;
        }

        .channelCategory-content {
            list-style: none;
            display: grid;
            grid-gap: 0.5rem;
            padding-left: 0;
            max-height: 500px;
            overflow-y: auto;
        }
        .channelCategory-content li {
            background-color: #f4f4f4;
            display: flex;
            align-items: center;
            gap: 1rem;
            padding: 15px;
        }
        .channelCategory-content li img {
            max-width: 2.5rem;
        }
        .channelCategory-content li h4 {
        margin: 0;
            font-size: 1.5rem;
        }
    </style>

    </head>

    <body>
    <section class="categoryList-dropdown-container">
        <div class="categoryList-dropdown">
        <input
            type="text"
            placeholder="Search channel list"
            class="categoryList-search"
            id="searchChannelCategory"
        />
        <ul class="dropdown-list" id="categoryList"></ul>
        </div>

        <ul class="channelCategory-content" id="channelCategory-contentList">
            Select channel to see list
        </ul>
    </section>

    <script>
        let channelListAPI = 'https://apihubs.cc/?api_key=NTafVRpzC3WLBavYPL3bP3BXchSreMqHFnKr7U8RY4WCmTEHPVmRhqEe5NAprPpP&action=get_category&type=streams';
        async function getData(api) {
            const res = await fetch(api);
            const data = await res.json();
            return data;
        }

        function generateChannelListItem(channel) {
            let li = document.createElement("li");
            li.innerText = channel.category_name;
            li.setAttribute("data-id", channel.id);
            return li;
        }

        function generateCategoryItem(category) {
            let li = document.createElement("li");
            let img = document.createElement("img");
            let h4 = document.createElement("h4");
            h4.innerText = category.name;
            img.src = category.stream_icon;
            img.setAttribute("loading", "lazy");
            li.insertAdjacentElement("beforeend", img);
            li.insertAdjacentElement("beforeend", h4);
            return li;
        }

        document.addEventListener("DOMContentLoaded", async function () {
        let channelList = await getData(channelListAPI);
        let categoryListContainer = document.getElementById("categoryList");
        channelList.data.forEach((channel) => {
            categoryListContainer.insertAdjacentElement("beforeend",generateChannelListItem(channel));
        });

        let categoryList = categoryListContainer.querySelectorAll("li");

        let searchChannelCategory = document.getElementById("searchChannelCategory");

        let categoryListContent = document.querySelector("#channelCategory-contentList");

        
        searchChannelCategory.addEventListener("focus", (e) => {
          e.target.value = "";
          // MAKE ALL VISIBLE WHEN SEARCH IS EMPTY
          Array.from(categoryList).forEach(function (item) {
            item.style.display = "";
          });
        });

        searchChannelCategory.addEventListener("keyup", function (e) {
            const searchValue = e.target.value.toLowerCase();

            if (!searchValue) {
                // categoryListContent.textContent = "Search Category List...";

                // MAKE ALL VISIBLE WHEN SEARCH IS EMPTY
                Array.from(categoryList).forEach(function (item) {
                    item.style.display = "";
                });
                return;
            }

            Array.from(categoryList).forEach(function (item) {
                let txtValue = item.textContent || item.innerText;
                if (txtValue.toLowerCase().indexOf(searchValue) > -1) {
                    item.style.display = "";
                } else {
                    item.style.display = "none";
                }
            });
        });

        // Add click event listeners to list items
        Array.from(categoryList).forEach(function (item) {
            item.addEventListener("click", function () {
                searchChannelCategory.value = this.textContent;
                let selectedId = this.getAttribute("data-id");
                generateCategoryList(selectedId);

                Array.from(categoryList).forEach(function (li) {
                    li.style.display = "none";
                });
            });
        });

        async function generateCategoryList(id) {
            categoryListContent.innerHTML = "";
            let categoryListAPI = 'https://apihubs.cc/?api_key=NTafVRpzC3WLBavYPL3bP3BXchSreMqHFnKr7U8RY4WCmTEHPVmRhqEe5NAprPpP&action=get_streams&type=streams&category_id=' + id;
            const categoryList = await getData(categoryListAPI);
            if (categoryList.status === "STATUS_FAILED") {
                categoryListContent.innerHTML = "No data found. Try another channel.";
            } else {
                categoryList.data.forEach((category) => {
                    categoryListContent.insertAdjacentElement("beforeend",generateCategoryItem(category));
                });
            }
        }
        });
    </script>
    </body>
</html>
