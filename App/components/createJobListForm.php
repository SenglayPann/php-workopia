<?php
  function createJobListingForm($errors, $filledData) {
    inspect($errors);
?>
<!-- Post a Job Form Box -->
<section class="flex justify-center container max-w-2xl mx-auto items-center mt-20">
  <div class="bg-white p-8 rounded-lg shadow-md w-full md:w-600 mx-6">
    <h2 class="text-4xl text-center font-bold mb-4">Create Job Listing</h2>
    <!-- <div class="message bg-red-100 p-3 my-3">This is an error message.</div>
    <div class="message bg-green-100 p-3 my-3">
      This is a success message.
    </div> -->
    <form method="POST" action="/listings">
      <h2 class="text-2xl font-bold mb-6 text-center text-gray-500">
        Job Info
      </h2>
      <div class="mb-4">
        <div class="<?= isset($errors['title']) ? 'bg-red-100 text-red-500 px-2 py-1 rounded inline-block mb-2' : '' ?>"><?= ( $errors['title'] ?? '') ?></div>
        <input
          type="text"
          name="title"
          placeholder="Job Title"
          class=" <?= isset($errors['title']) ? 'outline outline-red-500 outline-1': ''?> w-full px-4 py-2 border rounded focus:outline-none"
          value="<?php $filledData['title'] ?? ''; ?>"
        />
      </div>
      <div class="mb-4">
        <div class="<?= isset($errors['description']) ? 'bg-red-100 text-red-500 px-2 py-1 rounded inline-block mb-2' : '' ?>"><?= ( $errors['description'] ?? '') ?></div>
        <textarea
          name="description"
          placeholder="Job Description"
          class="<?= isset($errors['title']) ? 'outline outline-red-500 outline-1': ''?> w-full px-4 py-2 border rounded focus:outline-none"
        ><?php $filledData['description'] ?? ''; ?></textarea>
      </div>
      <div class="mb-4">
        <div class="<?= isset($errors['salary']) ? 'bg-red-100 text-red-500 px-2 py-1 rounded inline-block mb-2' : '' ?>"><?= ( $errors['salary'] ?? '') ?></div>
        <input
          type="text"
          name="salary"
          placeholder="Annual Salary"
          class="<?= isset($errors['salary']) ? 'outline outline-red-500 outline-1': ''?> w-full px-4 py-2 border rounded focus:outline-none"
          value="<?php $filledData['salary'] ?? ''; ?>"   
        />
      </div>
      <div class="mb-4">
        <div class="<?= isset($errors['requirements']) ? 'bg-red-100 text-red-500 px-2 py-1 rounded inline-block mb-2' : '' ?>"><?= ( $errors['requirements'] ?? '') ?></div>
        <input
          type="text"
          name="requirements"
          placeholder="Requirements"
          class="<?= isset($errors['requirements']) ? 'outline outline-red-500 outline-1': ''?> w-full px-4 py-2 border rounded focus:outline-none"
          value="<?php $filledData['requirements'] ?? ''; ?>"
        />
      </div>
      <div class="mb-4">
        <div class="<?= isset($errors['benefits']) ? 'bg-red-100 text-red-500 px-2 py-1 rounded inline-block mb-2' : '' ?>"><?= ( $errors['benefits'] ?? '') ?></div>
        <input
          type="text"
          name="benefits"
          placeholder="Benefits"
          class="<?= isset($errors['benefits']) ? 'outline outline-red-500 outline-1': ''?> w-full px-4 py-2 border rounded focus:outline-none"
          value="<?php $filledData['benefits'] ?? ''; ?>"
        />
      </div>
      <h2 class="text-2xl font-bold mb-6 text-center text-gray-500">
        Company Info & Location
      </h2>
      <div class="mb-4">
        <div class="<?= isset($errors['company']) ? 'bg-red-100 text-red-500 px-2 py-1 rounded inline-block mb-2' : '' ?>"><?= ( $errors['company'] ?? '') ?></div>
        <input
          type="text"
          name="company"
          placeholder="Company Name"
          class="<?= isset($errors['company']) ? 'outline outline-red-500 outline-1': ''?> w-full px-4 py-2 border rounded focus:outline-none"
          value="<?php $filledData['company'] ?? ''; ?>"
        />
      </div>
      <div class="mb-4">
       <div class="<?= isset($errors['address']) ? 'bg-red-100 text-red-500 px-2 py-1 rounded inline-block mb-2' : '' ?>"><?= ( $errors['address'] ?? '') ?></div>
        <input
          type="text"
          name="address"
          placeholder="Address"
          class="<?= isset($errors['address']) ? 'outline outline-red-500 outline-1': ''?> w-full px-4 py-2 border rounded focus:outline-none"
          value="<?php $filledData['address'] ?? ''; ?>"
          />
        </div>
      <div class="mb-4">
        <div class="<?= isset($errors['city']) ? 'bg-red-100 text-red-500 px-2 py-1 rounded inline-block mb-2' : '' ?>"><?= ( $errors['city'] ?? '') ?></div>
        <input
          type="text"
          name="city"
          placeholder="City"
          class="<?= isset($errors['city']) ? 'outline outline-red-500 outline-1': ''?> w-full px-4 py-2 border rounded focus:outline-none"
          value="<?php $filledData['city'] ?? ''; ?>"
        />
      </div>
      <div class="mb-4">
        <div class="<?= isset($errors['state']) ? 'bg-red-100 text-red-500 px-2 py-1 rounded inline-block mb-2' : '' ?>"><?= ( $errors['state'] ?? '') ?></div>
        <input
          type="text"
          name="state"
          placeholder="State"
          class="<?= isset($errors['state']) ? 'outline outline-red-500 outline-1': ''?> w-full px-4 py-2 border rounded focus:outline-none"
          value="<?php $filledData['state'] ?? ''; ?>"
        />
      </div>
      <div class="mb-4">
        <div class="<?= isset($errors['phone']) ? 'bg-red-100 text-red-500 px-2 py-1 rounded inline-block mb-2' : '' ?>"><?= ( $errors['phone'] ?? '') ?></div>
        <input
          type="text"
          name="phone"
          placeholder="Phone"
          class="<?= isset($errors['phone']) ? 'outline outline-red-500 outline-1': ''?> w-full px-4 py-2 border rounded focus:outline-none"
          value="<?php $filledData['phone'] ?? ''; ?>"
        />
      </div>
      <div class="mb-4">
        <div class="<?= isset($errors['email']) ? 'bg-red-100 text-red-500 px-2 py-1 rounded inline-block mb-2': '' ?>"><?= ( $errors['email'] ?? '') ?></div>
        <input
          type="email"
          name="email"
          placeholder="Email Address For Applications"
          class="<?= isset($errors['email']) ? 'outline outline-red-500 outline-1': ''?> w-full px-4 py-2 border rounded focus:outline-none"
          value="<?php $filledData['email'] ?? ''; ?>"
        />
      </div>
      <button
        class="w-full bg-green-500 hover:bg-green-600 text-white px-4 py-2 my-3 rounded focus:outline-none"
      >
        Save
      </button>
      <a
        href="/"
        class="block text-center w-full bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded focus:outline-none"
      >
        Cancel
      </a>
    </form>
  </div>
</section>

<?php
}
?>