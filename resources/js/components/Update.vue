// <template>
//   <div>
//     <div class="row">
//       <div class="col-md-6">
//         <br>
//         <br>
//         <h4>Update data</h4>
//         <br>
//         <!-- prevent form submit untuk reload halaman, kemudian memanggil function updateData() -->
//         <form @submit.prevent="updateData()">
//           <div class="form-group">
//             <label>First name</label>
//             <input
//               type="textfield"
//               class="form-control"
//               placeholder="Input your first name"
//               v-model="form.firstName"
//               required
//             >
//           </div>
//           <div class="form-group">
//             <label>Last name</label>
//             <input
//               type="textfield"
//               class="form-control"
//               placeholder="Input your last name"
//               v-model="form.lastName"
//               required
//             >
//           </div>
//           <button class="btn btn-primary">Submit</button>
//         </form>
//       </div>
//     </div>
//   </div>
// </template>

// <script>
// export default {
//   data() {
//     return {
//       form: {
//         firstName: "",
//         lastName: ""
//       }
//     };
//   },
//   created() {
//     // load data saat pertama kali halaman dibuka
//     this.loadData();
//   },
//   methods: {
//     loadData() {
//       // load data berdasarkan id
//       axios
//         .get("http://localhost:8000/api/person/" + this.$route.params.id)
//         .then(response => {
//           // post value yang dari response ke form
//           this.form.firstName = response.data.first_name;
//           this.form.lastName = response.data.last_name;
//         });
//     },
//     updateData() {
//       // put data ke api menggunakan axios
//       axios
//         .put("http://localhost:8000/api/person/" + this.$route.params.id, {
//           first_name: this.form.firstName,
//           last_name: this.form.lastName
//         })
//         .then(response => {
//           // push router ke read data
//           this.$router.push("/");
//         });
//     }
//   }
// };
// </script>