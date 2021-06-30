<template>
  <div>
    <div v-if="showSignupForm" >
          <form @submit="profileSubmit">
            <label>nom :</label>
            <input type="name" required v-model="nom" />
            <label>prenom :</label>
            <input type="text" required v-model="prenom" />
            <label>age :</label>
            <input type="age" required v-model="age" />
            <label>profession :</label>
            <input type="text" required v-model="profession" />
            <input type="hidden"  v-model="ref">

            <div class="submit">
              <button>Creer votre compte</button>
            </div>
          </form>
    </div>
    <div v-if="!showSignupForm">
              <form @submit="refSubmit">
                <label>Entrez votre code:</label>
                <input type="text" required v-model="ref" />
                <input type="submit" value="valider" />
              </form>
    </div>
    <button @click="toggleShowBox">
      <!-- <span>Vous avez deja votre ref ?</span> -->
      <span>inscrivez Vous</span>
    </button>
  </div>
</template>

<script>
export default {
  data() {
    return {
      showSignupForm: true,
      nom: "",
      prenom: "",
      age: "",
      profession: "",
      ref :""
    };
  },
  methods: {


    async refSubmit(e){
        e.preventDefault();
        const res = await fetch('http://localhost/vue-brief/project_6/test/Controller/checkRefUser.php',{
            method: 'POST',
            headers: {'Content-Type': 'application/json'},
            body: JSON.stringify({
                id: this.ref,
                })
            })
            const result = await res.json()
            if(result.message === 'client doesnt exist'){
              
              window.location.replace('/Create')
            }else{
              localStorage.setItem("token" ,  this.ref)
              window.location.replace('/DashClient')
            }
            return result
    },

    async profileSubmit(e){
        e.preventDefault();
        // end point
        const res = await fetch('http://localhost/vue-brief/project_6/test/Controller/creerClient.php',{
            method: 'POST',
            headers: {'Content-Type': 'application/json'},
            body: JSON.stringify({
                firstName: this.nom,
                  lastName: this.prenom,
                  age: this.age,
                  profession: this.profession
                })
            })
            const result = await res.json()
            localStorage.setItem("token" ,  result.token)
            this.showSignupForm = false;
            this.ref = result.token
            // if(!!result.token){
            //   window.location.replace('/Create')
            // }else{
            //   localStorage.setItem("token" ,  this.ref)
            //   // window.location.replace('/DashClient')
            // }
            return result
    },







      refSubmitOther(e) {
        e.preventDefault
    fetch(
        "http://localhost/vue-brief/project_6/test/Controller/creerClient.php",
        {
          method: "post",
          headers: {
            "Content-Type": "application/json",
          },
          body: JSON.stringify({
            id: this.ref
          }),
        }
      )
        .then((res) => {
          return res.json();
        })
        .then((data) => (console.log(data)))
        
        .then((data) => window.localStorage.setItem("reference",data));
        this.$router.push('/dashClient');
    },

   
    toggleShowBox() {
      this.showSignupForm = !this.showSignupForm;
    },
  },
};
</script>

<style scoped>
form {
  max-width: 480px;
  margin: 30px auto;
  background: rgb(134, 134, 134);
  text-align: left;
  padding: 40px;
  border-radius: 10px;
  font-family: "Times New Roman", Times, serif;
}
label {
  color: rgb(0, 0, 0);
  display: inline-block;
  margin: 25px 0 15px;
  font-size: 0.6em;
  text-transform: uppercase;
  letter-spacing: 1px;
  font-weight: bold;
}
input {
  display: block;
  padding: 10px 6px;
  width: 100%;
  box-sizing: border-box;
  border: none;
  border-bottom: 1px solid rgb(0, 0, 0);
  color: #555;
}

button {
  background: #a8a8a8;
  border: 0;
  padding: 10px 20px;
  margin-top: 20px;
  color: white;
  border-radius: 20px;
}
.submit {
  text-align: center;
}
</style>



//window.localStorage.getItem('reference');