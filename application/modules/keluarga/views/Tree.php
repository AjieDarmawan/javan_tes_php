<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <title>Pure CSS Tree Diagram</title>

    <link
      href="https://fonts.googleapis.com/css?family=Solway:400&display=swap"
      rel="stylesheet"
    />
    <link rel="stylesheet" href="./style.css" />
    <style>

body {
  font-family: "Solway", serif;
  font-size: 15px;
}

.tree img {
  width: 110px;
  border-radius: 50%;
}

.tree ul {
  position: relative;
  padding: 1em 0;
  white-space: nowrap;
  display: flex;
  text-align: center;
}

.tree ul .inn_line {
  padding: 50px 0 0;
}

.tree ul::after {
  content: '';
  display: table;
  clear: both;
}

.tree li {
  display: inline-block;
  vertical-align: top;
  text-align: center;
  list-style-type: none;
  position: relative;
  padding: 40px 0 0;
  width: 100%;
}

.tree li::before,
.tree li::after {
  content: '';
  position: absolute;
  top: 0;
  right: 50%;
  border-top: 5px solid #ccc;
  width: 50%;
  height: 45px;
  z-index: -1;
}

.tree li::after {
  right: auto;
  left: 50%;
  border-left: 5px solid #ccc;
}

.tree li:only-child::after,
.tree li:only-child::before {
  display: none;
}

.tree li:only-child {
  padding-top: 0;
}

.tree li:first-child::before,
.tree li:last-child::after {
  border: 0 none;
}

.tree li:last-child::before {
  border-right: 5px solid #ccc;
  border-radius: 0 5px 0 0;
}

.tree li:first-child::after {
  border-radius: 5px 0 0 0;
}

.tree ul ul::before {
  content: '';
  position: absolute;
  top: 10px;
  left: 50%;
  border-left: 5px solid #ccc;
  width: 0;
  height: 45px;
}

.tree li a {
  padding: 0;
  text-decoration: none;
  display: inline-block;
  border-radius: 5px;
  color: #333;
  position: relative;
  top: 1px;
}

.tree li a p {
  margin-top: 5px;
  font-size: 18px;
  font-weight: 700;
}
    </style>
  </head>
  <body>
    <!-- partial:index.partial.html -->
    <div class="tree">
      <ul>
        <li>
          <a href="#">
            <div class="mx-auto">
              <img
                src="https://cdn1.iconfinder.com/data/icons/user-avatars-2/300/10-512.png"
                alt="Sample avatar"
              />
            </div>
            <p class="font-weight-bold mt-4 mb-3">Budi</p>
          </a>
          <ul class="inn_line">
            <li>
              <a href="#">
                <div class="mx-auto">
                  <img
                    src="https://cdn2.iconfinder.com/data/icons/avatar-vol-1-5/512/7_Asian_avatar_businessman_chinese-512.png"
                    alt="Sample avatar"
                  />
                </div>
                <p class="font-weight-bold mt-4 mb-3">Dedi</p>
              </a>
              <ul class="inn_line">
                <li>
                  <a href="#">
                    <div class="mx-auto">
                    <img
                    src="https://cdn2.iconfinder.com/data/icons/avatar-vol-1-5/512/7_Asian_avatar_businessman_chinese-512.png"
                    alt="Sample avatar"
                      />
                    </div>
                    <p class="font-weight-bold mt-4 mb-3">Feri</p>
                  </a>
                
                </li>
                <li>
                  <a href="#">
                    <div class="mx-auto">
                    <img
                    src="https://i.pinimg.com/originals/d3/69/d9/d369d9056795f553e244da66e8297cca.png"
                    alt="Sample avatar"
                      />
                    </div>
                    <p class="font-weight-bold mt-4 mb-3">Farah</p>
                  </a>
               
                </li>
              </ul>
            </li>
            <li>
              <a href="#">
                <div class="mx-auto">
                  <img
                    src="https://cdn2.iconfinder.com/data/icons/avatar-vol-1-5/512/7_Asian_avatar_businessman_chinese-512.png"
                    alt="Sample avatar"
                  />
                </div>
                <p class="font-weight-bold mt-4 mb-3">Dodi</p>
              </a>
              <ul class="inn_line">
                <li>
                  <a href="#">
                    <div class="mx-auto">
                      <img
                        src="https://cdn2.iconfinder.com/data/icons/avatar-vol-1-5/512/7_Asian_avatar_businessman_chinese-512.png"
                        alt="Sample avatar"
                      />
                    </div>
                    <p class="font-weight-bold mt-4 mb-3">Gugus</p>
                  </a>
               
                </li>
                <li>
                  <a href="#">
                    <div class="mx-auto">
                    <img
                        src="https://cdn2.iconfinder.com/data/icons/avatar-vol-1-5/512/7_Asian_avatar_businessman_chinese-512.png"
                        alt="Sample avatar"
                      />
                    </div>
                    <p class="font-weight-bold mt-4 mb-3">Gandi</p>
                  </a>
                 
                </li>
              </ul>
            </li>
            <li>
              <a href="#">
                <div class="mx-auto">
                <img
                        src="https://cdn2.iconfinder.com/data/icons/avatar-vol-1-5/512/7_Asian_avatar_businessman_chinese-512.png"
                        alt="Sample avatar"
                  />
                </div>
                <p class="font-weight-bold mt-4 mb-3">Dede</p>
              </a>
              <ul class="inn_line">
              <li>
              <a href="#">
                <div class="mx-auto">
                  <img
                    src="https://i.pinimg.com/originals/d3/69/d9/d369d9056795f553e244da66e8297cca.png"
                    alt="Sample avatar"
                  />
                </div>
                <p class="font-weight-bold mt-4 mb-3">Hani</p>
              </a>
              
            </li>
            <li>
                  <a href="#">
                    <div class="mx-auto">
                    <img
                    src="https://i.pinimg.com/originals/d3/69/d9/d369d9056795f553e244da66e8297cca.png"
                    alt="Sample avatar"
                      />
                    </div>
                    <p class="font-weight-bold mt-4 mb-3">Hana</p>
                  </a>
               
                </li>
              </ul>
            </li>
            <li>
              <a href="#">
                <div class="mx-auto">
                <img
                    src="https://i.pinimg.com/originals/d3/69/d9/d369d9056795f553e244da66e8297cca.png"
                    alt="Sample avatar"
                  />
                </div>
                <p class="font-weight-bold mt-4 mb-3">Dewi</p>
              </a>
             
            </li>
            
          </ul>
        </li>
      </ul>
    </div>
    <!-- partial -->
  </body>
</html>
