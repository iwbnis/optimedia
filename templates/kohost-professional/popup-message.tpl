<style>
  * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      outline: none;
  }
  a,
  img,
  button,
  input,
  label,
  select,
  span,
  i {
      display: inline-block;
  }
  a {
      text-decoration: none;
      color: inherit;
  }
  ul {
      list-style: none;
  }
  img {
      width: 100%;
      height: 100%;
  }
  html {
      font-size: 62.5%;
  }

  .error-popup.active {
    opacity: 1;
    visibility: visible;
    z-index: 10 ;
    pointer-events: all;
  }
  .error-popup {
      transition: 0.7s;
      background: #fff;
      position: fixed;
      top: 50%;
      left: 50%;
      transform: translate(-50%, -50%);
      z-index: 10;
      max-width: 50rem;
      font-family: inherit;
      border: 2px solid red;
      padding: 2.5rem 2.5rem 2rem 2rem;
      border-radius: 1rem;
  }
  .error-popup .popup-close {
      position: absolute;
      right: 0.5rem;
      top: 0.5rem;
      background: none;
      border: none;
      color: rgb(0, 145, 255);
      cursor: pointer;
  }
  .error-popup .popup-close:hover {
      text-decoration: underline;
  }

  .error-popup .popup-heading {
      text-align: center;
      font-size: 3rem;
  }
  .error-popup hr {
      margin: 1rem 0 2rem;
  }

  .error-popup p {
      font-size: 1.8rem;
  }

</style>

<body>
    <section class="error-popup">
        <button class="popup-close">close</button>
        <h3 class="popup-heading">Service Outage Notification</h3>
        <hr />
        <p>
            We are currently experiencing unplanned service outage at our Data Center for
            <strong>Choice Server Only</strong>. Service will be restored as soon as possible.
            <strong>
                Do not submit a ticket at this time as techinicians are fixing the problem.
            </strong>
            Currently we don't have estimated time of restoration of service.
            <br />
            <br />
            We apologize for inconvenience and thank you for your patience.
            <br />
            <br />
            Choiceiptv.com Management
        </p>
    </section>
</body>

<script>
    const popupClose = document.querySelector(".popup-close");
    popupClose.addEventListener("click", (e) => {
        e.preventDefault();
        e.target.parentElement.classList.remove("active");
    });
</script>