<template>
  <footer>
    <div class="footer-bottom">
      <p>copyright &copy; <a href="#">Foolish Developer</a></p>
      <div class="footer-menu">
        <ul class="f-menu">
          <li><a href="">Home</a></li>
          <li><a href="">About</a></li>
          <li><a href="">Contact</a></li>
          <li><a href="">Blog</a></li>
        </ul>
      </div>
    </div>
  </footer>
</template>

<script>
export default {
  name: "Footer",
};
</script>
<style media="screen">
* {
  margin: 0;
  padding: 0;
  box-sizing: border-box;
}
body {
  background: #fcfcfc;
  font-family: sans-serif;
}
footer {
  position: absolute;
  bottom: 0;
  left: 0;
  right: 0;
  background: #111;
  height: 10rem;
  width: auto;

  padding-top: 40px;
  color: #fff;
}

.socials {
  list-style: none;
  display: flex;
  align-items: center;
  justify-content: center;
  margin: 1rem 0 3rem 0;
}
.socials li {
  margin: 0 10px;
}
.socials a {
  text-decoration: none;
  color: #fff;
  border: 1.1px solid white;
  padding: 5px;

  border-radius: 50%;
}
.socials a i {
  font-size: 1.1rem;
  width: 20px;

  transition: color 0.4s ease;
}
.socials a:hover i {
  color: aqua;
}

.footer-bottom {
  background: #000;
  width: auto;
  padding: 20px;
  padding-bottom: 40px;
  text-align: center;
}
.footer-bottom p {
  float: left;
  font-size: 14px;
  word-spacing: 2px;
  text-transform: capitalize;
}
.footer-bottom p a {
  color: #44bae8;
  font-size: 16px;
  text-decoration: none;
}
.footer-bottom span {
  text-transform: uppercase;
  opacity: 0.4;
  font-weight: 200;
}
.footer-menu {
  float: right;
}
.footer-menu ul {
  display: flex;
}
.footer-menu ul li {
  padding-right: 10px;
  display: block;
}
.footer-menu ul li a {
  color: #cfd2d6;
  text-decoration: none;
}
.footer-menu ul li a:hover {
  color: #27bcda;
}

@media (max-width: 500px) {
  .footer-menu ul {
    display: flex;
    margin-top: 10px;
    margin-bottom: 20px;
  }
}
</style>