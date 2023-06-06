<?php $this->view('admin/admin-header', $data) ?>

<style>
  .tabs-holder {
    display: flex;
    margin-top: 10px;
    margin-bottom: 10px;
    justify-content: center;
    text-align: center;
    flex-wrap: wrap;
  }

  .my-tab {
    flex: 1;
    border-bottom: solid 2px #ccc;
    padding-top: 10px;
    padding-bottom: 10px;
    cursor: pointer;
    user-select: none;
    min-width: 150px;

  }

  .my-tab:hover {
    color: #4154f1;
  }

  .active-tab {
    color: #4154f1;
    border-bottom: solid 2px #4154f1;
  }

  .hide {
    display: none;
  }

  .loader {
    position: relative;
    width: 200px;
    height: 200px;
    left: 50%;
    top: 50%;
    transform: translateX(-50%);
    opacity: 0.5;
  }
</style>
<?php if ($action == 'add') : ?>
  <div class="card col-md-5 mx-auto">
    <div class="card-body">
      <h5 class="card-title">New Course</h5>
      <!-- No Labels Form -->
      <form method="POST" class="row g-3">
        <div class="col-md-12">
          <input value="<?= set_value('title') ?>" name="title" type="text" class="form-control <?= !empty($errors['title']) ? 'border-danger' : ''; ?>" placeholder="Course Tilte">
          <?php if (!empty($errors['title'])) : ?>
            <small class="text-danger"><?= $errors['title'] ?></small>
          <?php endif; ?>
        </div>

        <div class="col-md-12">
          <input value="<?= set_value('primary_subject') ?>" name="primary_subject" type="text" class="form-control <?= !empty($errors['primary_subject']) ? 'border-danger' : ''; ?>" placeholder="Primary Subject">
          <?php if (!empty($errors['primary_subject'])) : ?>
            <small class="text-danger"><?= $errors['primary_subject'] ?></small>
          <?php endif; ?>
        </div>

        <div class="col-md-12">
          <select name="category_id" id="inputState" class="form-select <?= !empty($errors['category_id']) ? 'border-danger' : ''; ?>">
            <option selected>Course Category...</option>
            <?php if (!empty($categories)) : ?>
              <?php foreach ($categories as $cat) : ?>
                <option <?= set_select('category_id', $cat->id) ?> value="<?= $cat->id ?>"><?= $cat->category ?></option>
              <?php endforeach; ?>
            <?php endif; ?>
          </select>
          <?php if (!empty($errors['category_id'])) : ?>
            <small class="text-danger"><?= $errors['category_id'] ?></small>
          <?php endif; ?>
        </div>
        <div class="text-center">
          <button type="submit" class="btn btn-primary">Save</button>
          <a href="<?= ROOT ?>/admin/courses">
            <button type="button" class="btn btn-secondary">Cancel</button>
          </a>
        </div>
      </form><!-- End No Labels Form -->

    </div>
  </div>
<?php elseif ($action == 'delete') : ?>
  <div class="card">
    <div class="card-body">
      <h5 class="card-title">Edit Course</h5>
      <?php if (!empty($row)) : ?>
        <div class="alert alert-danger text-center">Are You Sure You Want To Delete This Course?</div>
        <form method="post">
          <div class="float-end">
            <button class="btn btn-danger">delete</button>
            <a href="<?= ROOT ?>/admin/courses">
              <button class="btn btn-primary">Back</button>
            </a>
          </div>
          <h5 class="">Course Title: <?= $row->title ?></h5>
          <h5 class="">primary subject: <?= $row->primary_subject ?></h5>
          <h5 class="">Date: <?= $row->date ?></h5>
        </form>


      <?php else : ?>
        <div>That course was not found!</div>
      <?php endif; ?>

    </div>
  </div>


<?php elseif ($action == 'edit') : ?>

  <div class="card">
    <div class="card-body">
      <h5 class="card-title">Edit Course</h5>

      <?php if (!empty($row)) : ?>

        <div class="float-end">
          <a href="<?= ROOT ?>/admin/courses">
            <button class="btn btn-primary">Back</button>
          </a>
        </div>

        <h5 class=""><?= $row->title ?></h5>


        <div class="card tabs-holder ">
          <div class="card-body ">
            <h5 class="card-title"><?= $row->title ?></h5>

            <ul class="nav nav-tabs nav-tabs-bordered d-flex" id="borderedTabJustified" role="tablist">
              <li class="nav-item flex-fill my-tab" role="presentation">
                <button class="nav-link w-100 active my-tab" id="intended-learners" data-bs-toggle="tab" type="button" role="tab" data-bs-target="#bordered-justified-intended-learners">Intended Learners</button>
              </li>
              <li class="nav-item flex-fill my-tab" role="presentation">
                <button class="nav-link w-100 my-tab" id="curriculum" data-bs-toggle="tab" type="button" role="tab" data-bs-target="#bordered-justified-curriculum">Curriculum</button>
              </li>
              <li class="nav-item flex-fill my-tab" role="presentation">
                <button class="nav-link w-100 my-tab" id="course-landing-page" data-bs-toggle="tab" type="button" role="tab" data-bs-target="#bordered-justified-course-landing">Course Landing</button>
              </li>
              <li class="nav-item flex-fill my-tab" role="presentation">
                <button class="nav-link w-100 my-tab" id="promotions" data-bs-toggle="tab" type="button" role="tab" data-bs-target="#bordered-justified-promotions">Promotions</button>
              </li>
              <li class="nav-item flex-fill my-tab" role="presentation">
                <button class="nav-link w-100 my-tab" id="course-messages" data-bs-toggle="tab" type="button" role="tab" data-bs-target="#bordered-justified-course-messages">Course Messages</button>
              </li>
            </ul>

            <div class="tab-content pt-2" id="borderedTabJustifiedContent">
              <div class="tab-pane fade show active" id="bordered-justified-intended-learners" role="tabpanel" aria-labelledby="home-tab">

              </div>
              <div class="tab-pane fade" id="bordered-justified-curriculum" role="tabpanel" aria-labelledby="profile-tab">
                Nesciunt totam et. Consequuntur magnam aliquid eos nulla dolor iure eos quia. Accusantium distinctio omnis et atque fugiat. Itaque doloremque aliquid sint quasi quia distinctio similique. Voluptate nihil recusandae mollitia dolores. Ut laboriosam voluptatum dicta.
              </div>
              <div class="tab-pane fade" id="bordered-justified-course-landing" role="tabpanel" aria-labelledby="contact-tab">
                <?php include 'course-edit-tabs/course-landing-page.view.php' ?>
              </div>
              <div class="tab-pane fade" id="bordered-justified-promotions" role="tabpanel" aria-labelledby="contact-tab">
                Saepe animi et soluta ad odit soluta sunt. Nihil quos omnis animi debitis cumque. Accusantium quibusdam perspiciatis qui qui omnis magnam. Officiis accusamus impedit molestias nostrum veniam. Qui amet ipsum iure. Dignissimos fuga tempore dolor.
              </div>
              <div class="tab-pane fade" id="bordered-justified-course-messages" role="tabpanel" aria-labelledby="contact-tab">
                <?php include 'course-edit-tabs/message-course.view.php' ?>
              </div>
            </div><!-- End Bordered Tabs Justified -->

          </div>
        </div>

      <?php else : ?>
        <div>That course was not found!</div>
      <?php endif; ?>

    </div>
  </div>


<?php else : ?>
  <div class="card">
    <div class="card-body">
      <h5 class="card-title">
        Courses
        <a href="<?= ROOT ?>/admin/courses/add">
          <button class="btn btn-primary float-end">New Course <i class="bi bi-camera-video"></i></button>
        </a>
      </h5>
      <!-- Table with stripped rows -->
      <table class="table table-striped">
        <thead>
          <tr>
            <th scope="col">#</th>
            <th scope="col">Title</th>
            <th scope="col">Instractor</th>
            <th scope="col">Category</th>
            <th scope="col">Price</th>
            <th scope="col">Primary Subject</th>
            <th scope="col">Date</th>
            <th scope="col">Action</th>
          </tr>
        </thead>
        <?php if (!empty($rows)) : ?>
          <tbody>
            <?php foreach ($rows as $row) : ?>
              <tr>
                <th scope="row"><?= $row->id ?></th>
                <td><?= $row->title ?></td>
                <td><?= $row->firstname ?></td>
                <td><?= $row->category ?></td>
                <td><?= $row->pricename ?></td>
                <td><?= $row->primary_subject ?></td>
                <td><?= get_date($row->date) ?></td>
                <td>
                  <a href="<?= ROOT ?>/admin/courses/edit/<?= $row->id ?>">
                    <i class="bi bi-pencil-square"></i>
                  </a>
                  <a href="<?= ROOT ?>/admin/courses/delete/<?= $row->id ?>">
                    <i class="bi bi-trash-fill text-danger"></i>
                  </a>
                </td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        <?php else : ?>
          <tr>
            <td colspan="10">no record found!</td>
          </tr>
        <?php endif; ?>

      </table>
      <!-- End Table with stripped rows -->
    </div>
  </div>

<?php endif; ?>

<script>
  var tab = sessionStorage.getItem("tab") ? sessionStorage.getItem("tab") : "intended-learners";
  var dirty = false;

  function show_tab(tab_name) {

    var contentDiv = document.querySelector("#tabs-content");
    show_loader(contentDiv);

    //change active tab
    var div = document.querySelector("#" + tab_name);
    var children = div.parentNode.children;
    for (var i = 0; i < children.length; i++) {
      children[i].classList.remove("active-tab");
    }

    div.classList.add("active-tab");


    send_data({
      tab_name: tab,
      data_type: "read",
    });

    disable_save_button(false);

  }

  function handle_result(result) {

    //console.log(result);
    if (result.substr(0, 2) == '{"') {
      var obj = JSON.parse(result);
      if (typeof obj == 'object') {

        if (obj.data_type == "save") {

          alert("data saved");
          disable_save_button(false);
        }

      }

    } else {

      var contentDiv = document.querySelector("#tabs-content");
      contentDiv.innerHTML = result;
    }

  }

  function set_tab(tab_name) {

    if (dirty) {
      //ask user to save when switching tabs
      if (!confirm("Your changes were not saved. continue?!")) {
        return;
      }
    }

    tab = tab_name;
    sessionStorage.setItem("tab", tab_name);

    dirty = false;
    show_tab(tab_name);

  }

  function something_changed(e) {
    dirty = tab;
    disable_save_button(true);
  }

  function disable_save_button(status = false) {
    if (status) {
      document.querySelector(".js-save-button").classList.remove("disabled");
    } else {
      document.querySelector(".js-save-button").classList.add("disabled");
    }
  }

  function show_loader(item) {
    item.innerHTML = '<img class="loader" src="<?= ROOT ?>/assets/images/loader.gif">';
  }

  show_tab(tab);

</script>
<?php $this->view('admin/admin-footer', $data) ?>