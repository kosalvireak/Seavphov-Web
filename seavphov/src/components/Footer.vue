<template>
  <footer v-if="hideFooter" class="footer-section w-100 bg-seavphov">
    <div class="container-xl footer-content pt-5 pb-10">
      <div class="row space-y-4">
        <div class="col-xl-4 col-lg-4 mb-50">
          <div class="footer-widget">
            <div class="footer-logo">
              <a href="/home"
                ><img
                  :src="logoUrl"
                  class="img-fluid"
                  alt="logo"
                  style="height: 65px"
              /></a>
            </div>
            <div class="copyright-text">
              <p>
                Copyright &copy; 2025, All Right Reserved
                <a href="#">Seavphov</a>
              </p>
            </div>
          </div>
        </div>
        <div class="col-xl-4 col-lg-4 col-md-6 mb-30">
          <div class="footer-widget">
            <div class="footer-widget-heading">
              <h3>Useful Links</h3>
            </div>
            <ul>
              <li>
                <router-link :to="{ name: 'about-us' }"> About us </router-link>
              </li>
              <li>
                <router-link :to="{ name: 'discussion' }">
                  Discussion
                </router-link>
              </li>
              <li>
                <router-link :to="{ name: 'search-community' }">
                  Community
                </router-link>
              </li>
              <li>
                <router-link :to="{ name: 'search' }"> Search Book</router-link>
              </li>
            </ul>
          </div>
        </div>
        <div class="col-xl-4 col-lg-4 col-md-6 mb-50">
          <div class="footer-widget">
            <div class="footer-widget-heading">
              <h3>Subscribe</h3>
            </div>
            <div class="footer-text mb-25">
              <p>
                Get instant notifications when a new book is added — just fill
                out the form below to subscribe to our updates!
              </p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </footer>
</template>

<script>
export default {
  name: "Footer",
  data() {
    return {
      logoUrl: Seavphov.logoUrl,
      route: this.$route.name,
      hideFooter: true,
      hiddenRouteList: [
        "login",
        "signup",
        "forgot-password",
        "community",
        "admin",
      ],
    };
  },
  watch: {
    "$route.fullPath": {
      immediate: true,
      handler(newPath) {
        const matched = this.hiddenRouteList.some((route) =>
          newPath.includes(route),
        );
        this.hideFooter = !matched;
      },
    },
  },
};
</script>
<style media="screen">
ul {
  margin: 0px;
  padding: 0px;
}
/* .footer-section {
  position: relative;
  bottom: 0;
} */
.footer-cta {
  border-bottom: 1px solid #373636;
}
.single-cta i {
  color: #ff5e14;
  font-size: 30px;
  float: left;
  margin-top: 8px;
}
.cta-text {
  padding-left: 15px;
  display: inline-block;
}
.cta-text h4 {
  color: #fff;
  font-size: 20px;
  font-weight: 600;
  margin-bottom: 2px;
}
.cta-text span {
  color: #000000;
  font-size: 15px;
}
.footer-content {
  position: relative;
  z-index: 2;
}
.footer-pattern img {
  position: absolute;
  top: 0;
  left: 0;
  height: 330px;
  background-size: cover;
  background-position: 100% 100%;
}
.footer-logo {
  margin-bottom: 30px;
}
.footer-logo img {
  max-width: 200px;
}
.footer-text p {
  margin-bottom: 14px;
  font-size: 14px;
  color: #000000;
  line-height: 28px;
}
.footer-social-icon span {
  color: #fff;
  display: block;
  font-size: 20px;
  font-weight: 700;
  font-family: "Poppins", sans-serif;
  margin-bottom: 20px;
}
.footer-social-icon a {
  color: #fff;
  font-size: 16px;
  margin-right: 15px;
}
.footer-social-icon i {
  height: 40px;
  width: 40px;
  text-align: center;
  line-height: 38px;
  border-radius: 50%;
}
.facebook-bg {
  background: #3b5998;
}
.twitter-bg {
  background: #55acee;
}
.google-bg {
  background: #dd4b39;
}
.footer-widget-heading h3 {
  color: #fff;
  font-size: 20px;
  font-weight: 600;
  margin-bottom: 40px;
  position: relative;
}
.footer-widget-heading h3::before {
  content: "";
  position: absolute;
  left: 0;
  bottom: -15px;
  height: 2px;
  width: 50px;
  background: #ff5e14;
}
.footer-widget ul li {
  display: inline-block;
  width: 50%;
  margin-bottom: 12px;
}
.footer-widget ul li a:hover {
  color: #edf8f5;
}
.footer-widget ul li a {
  color: #000000;
  text-transform: capitalize;
}
.subscribe-form {
  position: relative;
  overflow: hidden;
}
.subscribe-form input {
  width: 100%;
  padding: 14px 28px;
  background: #2e2e2e;
  border: 1px solid #2e2e2e;
  color: #fff;
}
.subscribe-form button {
  position: absolute;
  right: 0;
  background: #ff5e14;
  padding: 13px 20px;
  top: 0;
}
.subscribe-form button i {
  color: #fff;
  font-size: 22px;
  transform: rotate(-6deg);
}
.copyright-area {
  padding: 25px 0;
}
.copyright-text p {
  margin: 0;
  font-size: 14px;
  color: #000000;
}
.copyright-text p a {
  color: #edf8f5;
}
.footer-menu li {
  display: inline-block;
  margin-left: 20px;
}
.footer-menu li:hover a {
  color: #edf8f5;
}
.footer-menu li a {
  font-size: 14px;
  color: #000000;
}
</style>
