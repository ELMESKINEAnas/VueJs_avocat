<template>
  <div class="table-wrapper">
      <button @click="createRdvShow">create rdv</button>
      <button @click="logout">Logout</button>
    <form v-if="createRdv">
      <input type="text" placeholder="sujet" v-model="sujet" />
      
      <input type="date" placeholder="la date"  @change="get_time" v-model="date_book" />
      
      <select v-model="id_creneau">
          
        <option disabled >svp prenez votre creneau adequat</option>
        <option v-for="date_dispo in date_disponible" :key="date_dispo"  @change="test">{{date_dispo}}</option>
      </select>

        <input type="submit"  @click.prevent="send_rdv()" value="Send" />
    </form>
    <!-- <p>{{ tables[0].firstName }} {{ tables[0].lastName }}</p> -->
    <table class="fl-table">
      <thead>
        <tr>
          <th>La date</th>
          <th>Creneau</th>
          <th>Sujet</th>
          <th>delete</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="(rdv, index) in tables.RDVS" :key="rdv.id_rdv">
    
          <td>{{ tables.RDVS[index].ladate }}</td>
          <td>{{ tables.RDVS[index].creneaux }}</td>
          <td>{{ tables.RDVS[index].sujet }}</td>
          <td><button @click="delete_rdv(rdv.id_rdv)">delete</button></td>

        </tr>
      </tbody>
    </table>
  </div>
</template>

<script>
// import { onBeforeMount } from "@vue/runtime-core";

export default {
  data() {
    return {
      tables: [],
      createRdv:false,
      date_book :'',
      date_disponible : '',
      id_creneau:'',
      sujet:'',
    };
  },
  methods: {
      test(){
console.log();
      },
      createRdvShow(){
          this.sujet=""
          this.ladate=""
          this.id_creneau=""
          this.createRdv = !this.createRdv
      },
    async getRDVs() {
      const reference = {
        reference: localStorage.getItem("token"),
      };

      var res = await fetch(
        "http://localhost/vue-brief/project_6/test/Controller/readRDV.php",
        {
          method: "POST",
          header: "Content-type: application/json",

          body: JSON.stringify(reference),
        }
      );
      if (res.status === 200) {
        this.tables = await res.json();
        // console.log(this.tables.RDVS.RDV.id_rdv);
        console.log(this.tables.RDVS);
      }
    },
    get_time:  async function(){
            let Api = "http://localhost/vue-brief/project_6/test/Controller/checkDate.php";
            const params = {method:"POST",headers:{'Content-type': 'application/json'},body:JSON.stringify({"ladate":this.date_book})}
            var res = await fetch(Api, params)
            let reponse = await res.json();
            this.date_disponible = reponse;
            // console.log(reponse)
    },
      send_rdv : async function(){
      let Api="http://localhost/vue-brief/project_6/test/Controller/creerRDV.php";
            const params = {method:"POST",headers:{'Content-type': 'application/json'},body:JSON.stringify({
                id_client: localStorage.getItem("token"),
                sujet: this.sujet,
                ladate: this.date_book,
                id_creneau: this.id_creneau
            })}
            var res = await fetch(Api, params)
            let reponse = await res.json();
            // this.date_disponible = reponse;
            console.log(reponse);
            console.log("timeeeeeeeeeeeeees  : " + this.id_creneau);
            this.getRDVs();
            this.get_time();

  },
      delete_rdv : async function(idrdv){
      let Api="http://localhost/vue-brief/project_6/test/Controller/deleteRDV.php";
            const params = {method:"DELETE",headers:{'Content-type': 'application/json'},body:JSON.stringify({
                id_rdv: idrdv
            })}
            var res = await fetch(Api, params)
            let reponse = await res.json();
            // this.date_disponible = reponse;
            console.log(reponse);
            this.getRDVs();

  },
  logout(){
localStorage.clear();
 this.$router.push('/home');
  }
  },

  beforeMount() {
    this.getRDVs();
  },
};
</script>




<style scoped>
h2 {
  text-align: center;
  font-size: 18px;
  text-transform: uppercase;
  letter-spacing: 1px;
  color: white;
  padding: 30px 0;
}

/* Table Styles */

.table-wrapper {
  margin: 10px 70px 70px;
  box-shadow: 0px 35px 50px rgba(0, 0, 0, 0.2);
}

.fl-table {
  border-radius: 5px;
  font-size: 12px;
  font-weight: normal;
  border: none;
  border-collapse: collapse;
  width: 100%;
  max-width: 100%;
  white-space: nowrap;
  background-color: white;
}

.fl-table td,
.fl-table th {
  text-align: center;
  padding: 8px;
}

.fl-table td {
  border-right: 1px solid #f8f8f8;
  font-size: 12px;
}

.fl-table thead th {
  color: #ffffff;
  background: #4fc3a1;
}

.fl-table thead th:nth-child(odd) {
  color: #ffffff;
  background: #324960;
}

.fl-table tr:nth-child(even) {
  background: #f8f8f8;
}

/* Responsive */

@media (max-width: 767px) {
  .fl-table {
    display: block;
    width: 100%;
  }
  .table-wrapper:before {
    content: "Scroll horizontally >";
    display: block;
    text-align: right;
    font-size: 11px;
    color: white;
    padding: 0 0 10px;
  }
  .fl-table thead,
  .fl-table tbody,
  .fl-table thead th {
    display: block;
  }
  .fl-table thead th:last-child {
    border-bottom: none;
  }
  .fl-table thead {
    float: left;
  }
  .fl-table tbody {
    width: auto;
    position: relative;
    overflow-x: auto;
  }
  .fl-table td,
  .fl-table th {
    padding: 20px 0.625em 0.625em 0.625em;
    height: 60px;
    vertical-align: middle;
    box-sizing: border-box;
    overflow-x: hidden;
    overflow-y: auto;
    width: 120px;
    font-size: 13px;
    text-overflow: ellipsis;
  }
  .fl-table thead th {
    text-align: left;
    border-bottom: 1px solid #f7f7f9;
  }
  .fl-table tbody tr {
    display: table-cell;
  }
  .fl-table tbody tr:nth-child(odd) {
    background: none;
  }
  .fl-table tr:nth-child(even) {
    background: transparent;
  }
  .fl-table tr td:nth-child(odd) {
    background: #f8f8f8;
    border-right: 1px solid #e6e4e4;
  }
  .fl-table tr td:nth-child(even) {
    border-right: 1px solid #e6e4e4;
  }
  .fl-table tbody td {
    display: block;
    text-align: center;
  }
}
</style>