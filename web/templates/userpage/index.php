<?php ob_start();
if (isset($_SESSION['fatal_error'])) {
} ?>
<!-- ======= Hero Section ======= -->
<section id="hero" class="d-flex flex-column justify-content-center align-items-center">
  <div class="hero-container" data-aos="fade-in">
    <h1 class="text-capitalize">Welcome back, <?php echo isset($_SESSION['username']) ? $_SESSION['username'] : 'user'; ?>.</h1>
    <p>Here you can <span class="typed" data-typed-items="Post, Comment, Delete, Search, FIlter"></span></p>
  </div>
</section><!-- End Hero -->

<main id="main">

  <!-- ======= About Section ======= -->
  <section id="myposts" class="about">
    <div class="container">

      <div class="section-title">
        <h2>My Posts<a class="btn btn-outline-secondary ms-3 reload" id="reloadMyPosts"><i class="bi bi-arrow-clockwise"></i></a></h2>
        <!--
        <p>Magnam dolores commodi suscipit. Necessitatibus eius consequatur ex aliquid fuga eum quidem. Sit sint consectetur velit. Quisquam quos quisquam cupiditate. Et nemo qui impedit suscipit alias ea. Quia fugiat sit in iste officiis commodi quidem hic quas.</p>
-->
      </div>

      <div class="row">
        <!-- Datatable -->
        <div class="col-12" data-aos="fade-right">
          <div class="card recent-sales overflow-auto">
            <!-- Filter (Extra)
            <div class="filter">
              <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
              <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                <li class="dropdown-header text-start">
                  <h6>Filter</h6>
                </li>

                <li><a class="dropdown-item" href="#">Today</a></li>
                <li><a class="dropdown-item" href="#">This Month</a></li>
                <li><a class="dropdown-item" href="#">This Year</a></li>
              </ul>
            </div>
              -->
            <div class="card-body">
              <h5 class="card-title">Forum <span>| My Posts</span></h5>
              <table class="table table-borderless datatable">
                <thead>
                  <tr>
                    <th scope="col">#</th>
                    <th scope="col">Title</th>
                    <th scope="col">Author</th>
                    <th scope="col">Creation Date</th>
                    <th scope="col">Visibility</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  if (isset($userPostsList)) {
                    foreach ($userPostsList as $i => $post) {
                      echo '<tr>
                      <th scope="row">#' . $i++ . '</th>
                      <td><a href="index.php?ctl=post&id=' . $post['topic_id'] . '">' . $post['topic_title'] . '</a></td>
                      <td><a href="#" class="text-primary">' . $post['username'] . '</a></td>
                      <td class="date-created">' . gmdate("d-m-Y H:i", $post['date_created']) . '</td>
                      <td><a data-bs-target="#visibilityModal" data-bs-toggle="modal"' . getVisibilityBadge($post['visibility']) . '</a></td>
                    </tr>';
                    }
                  }
                  ?>
                </tbody>
              </table>

            </div>

          </div>
        </div><!-- End Datatable -->
      </div>

    </div>
  </section><!-- End About Section -->

  <!-- ======= Facts Section ======= -->
  <section id="new" class="facts">
    <div class="container">

      <div class="section-title">
        <h2>New Post</h2>
        <p>Note: By creating a post, you agree to follow the <a href="templates/docs/FindIt_TermsOfAgreement.pdf">Community Guidelines</a>.</p>
      </div>
      <div class="row">
        <div class="col-12">
          <form id="formPost">
            <div class="row">
              <div class="col form-group">
                <input type="text" name="title" class="form-control" id="title" placeholder="Title" required />
              </div>
              <div class="col">
                <div class="form-floating mb-3">
                  <select class="form-select" id="category" name="category" title="Choose a category" required>
                    <option value="2">Public</option>
                    <option value="1">Friends</option>
                    <option value="0">Private</option>
                  </select>
                  <label for="category">Category: </label>
                </div>
              </div>
            </div>
            <!-- ADD TAG SELECT -->
            <div class="form-group mt-3">
              <textarea class="form-control" name="message" rows="5" placeholder="Message" required></textarea>
            </div>
            <div class="text-center">
              <button class="btn btn-primary mt-3" type="button" id="toastResponseBtn">Create Post</button>
            </div>
            <div class="d-flex align-items-center justify-content-center">
              <!-- Generate alert w/ js -->
              <div class="alert alert-success p-1 mt-3" role="alert" id="postAlert">
                <i class="bi bi-check-circle me-2"></i>Post created successfully!
              </div>
            </div>
        </div>
        </form>
      </div>

    </div>
  </section><!-- End Facts Section -->

  <!-- ======= Skills Section ======= -->
  <section id="saved" class="skills section-bg">
    <div class="container">

      <div class="section-title">
        <h2>Saved Posts<a class="btn btn-outline-secondary ms-3 reload" id="reloadSaved"><i class="bi bi-arrow-clockwise"></i></a></h2>
        <!--
        <p>Magnam dolores commodi suscipit. Necessitatibus eius consequatur ex aliquid fuga eum quidem. Sit sint consectetur velit. Quisquam quos quisquam cupiditate. Et nemo qui impedit suscipit alias ea. Quia fugiat sit in iste officiis commodi quidem hic quas.</p>
                -->
      </div>

      <div class="row">
        <!-- Datatable -->
        <div class="col-12" data-aos="fade-right">
          <div class="card recent-sales overflow-auto">
            <!-- Filter (Extra)
            <div class="filter">
              <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
              <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                <li class="dropdown-header text-start">
                  <h6>Filter</h6>
                </li>

                <li><a class="dropdown-item" href="#">Today</a></li>
                <li><a class="dropdown-item" href="#">This Month</a></li>
                <li><a class="dropdown-item" href="#">This Year</a></li>
              </ul>
            </div>
              -->
            <div class="card-body">
              <h5 class="card-title">Forum <span>| Saved Posts</span></h5>
              <table class="table table-borderless datatable">
                <thead>
                  <tr>
                    <th scope="col">#</th>
                    <th scope="col">Title</th>
                    <th scope="col">Author</th>
                    <th scope="col">Creation Date</th>
                    <th scope="col">Visibility</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  if (isset($savedPostsList)) {
                    foreach ($savedPostsList as $i => $post) {
                      echo '<tr>
                      <a href="index.php?ctl=post&id=' . $post['topic_id'] . '">
                        <th scope="row">#' . $i++ . '</th>
                        <td>' . $post['topic_title'] . '</td>
                        <td><a href="#" class="text-primary">' . $post['username'] . '</a></td>
                        <td class="date-created">' . gmdate("d-m-Y H:i", $post['date_created']) . '</td>
                        <td><span' . getVisibilityBadge($post['visibility']) . '</span></td>
                      </a>
                    </tr>';
                    }
                  }
                  ?>
                </tbody>
              </table>

            </div>

          </div>
        </div><!-- End Datatable -->
      </div>

    </div>
  </section><!-- End Saved Posts Section -->

  <!-- ======= Public Posts Section ======= -->
  <section id="forum" class="mb-5 resume">
    <div class="container">

      <div class="section-title">
        <h2>Forum<a class="btn btn-outline-secondary ms-3 reload" id="reloadForum"><i class="bi bi-arrow-clockwise"></i></a></h2>
        <!--
        <p>Magnam dolores commodi suscipit. Necessitatibus eius consequatur ex aliquid fuga eum quidem. Sit sint consectetur velit. Quisquam quos quisquam cupiditate. Et nemo qui impedit suscipit alias ea. Quia fugiat sit in iste officiis commodi quidem hic quas.</p>
      -->
      </div>

      <div class="row">
        <!-- Datatable -->
        <div class="col-12" data-aos="fade-up">
          <div class="card recent-sales overflow-auto">
            <!-- Filter (Extra)
            <div class="filter">
              <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
              <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                <li class="dropdown-header text-start">
                  <h6>Filter</h6>
                </li>

                <li><a class="dropdown-item" href="#">Today</a></li>
                <li><a class="dropdown-item" href="#">This Month</a></li>
                <li><a class="dropdown-item" href="#">This Year</a></li>
              </ul>
            </div>
              -->
            <div class="card-body">
              <h5 class="card-title">Forum <span>| Latest Posts</span></h5>
              <table class="table table-borderless datatable">
                <thead>
                  <tr>
                    <th scope="col">#</th>
                    <th scope="col">Title</th>
                    <th scope="col">Author</th>
                    <th scope="col">Creation Date</th>
                    <th scope="col">Visibility</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  if (isset($postsList)) {
                    foreach ($postsList as $i => $post) {
                      echo '<tr>
                      <th scope="row">#' . $i++ . '</th>
                      <td><a href="index.php?ctl=post&id=' . $post['topic_id'] . '">' . $post['topic_title'] . '</a></td>
                      <td><a href="#" class="text-primary">' . $post['username'] . '</a></td>
                      <td class="date-created">' . gmdate("d-m-Y H:i", $post['date_created']) . '</td>
                      <td><span' . getVisibilityBadge($post['visibility']) . '</span></td>
                    </tr>';
                    }
                  }
                  ?>
                </tbody>
              </table>

            </div>

          </div>
        </div><!-- End Datatable -->
      </div>

    </div>
  </section><!-- End Public Posts Section -->

</main><!-- End #main -->

<?php
$contenido = ob_get_clean();
$pie = 'templates/userpage/footer.php';
?>

<?php include 'templates/layout.php' ?>