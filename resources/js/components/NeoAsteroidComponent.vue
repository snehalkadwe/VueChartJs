<template>
  <div class="container">
    <div class="row">
      <div class="col-md-6">
        <h3 class="text-info">Neo Asteroid Controller</h3>
        <form action v-on:submit.prevent="getNeoDate()">
          You have selected start date {{ start_date }} and end date {{ end_date }}
          <div class="mt-4">
            <label>Strat Date</label>
            <input type="date" name="start_date" class="form-control col-md-6" v-model="start_date" />
          </div>
          <div class="mt-4">
            <label>End Date</label>
            <input type="date" name="end_date" class="form-control col-md-6" v-model="end_date" />
          </div>
          <div class="mt-4">
            <button type="submit" class="btn btn-secondary">Submit</button>
          </div>
        </form>
      </div>
      <div class="col-md-6">
        <h3 class="text-info">NEO Chart</h3>
        <canvas id="neoChart"></canvas>
      </div>
    </div>
    <div class="mr-auto col-md-12 mt-4">
      <h3 class="text-info">NEO Asteroid Data</h3>
      <h4>Fastest Asteroid Id & Speed(in KM/Hour)</h4>
      <p>{{fastest_asteroid_id }}, {{fastest_asteroid }}</p>
      <h4>Closest Asteroid id and distance</h4>
      <p>
        {{NeoClosest_id }}
        {{NeoClosest }}
      </p>
      <h4>Total No of Asteroids</h4>
      <p>{{ asteroids_count_values }}</p>
      <h4>Keys</h4>
      <p>{{ total_no_of_asteroid }}</p>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      start_date: null,
      end_date: null,
      fastest_asteroid_id: "",
      fastest_asteroid: "",
      NeoClosest_id: "",
      NeoClosest: "",
      total_no_of_asteroid: "",
      asteroids_count_values: "",
    };
  },
  methods: {
    getNeoDate() {
      axios
        .post("/getNeoDate", {
          start_date: this.start_date,
          end_date: this.end_date,
        })
        .then((response) => {
          (this.fastest_asteroid_id = response.data.fastest_asteroid_id),
            (this.fastest_asteroid = response.data.fastest_asteroid),
            (this.NeoClosest_id = response.data.NeoClosest_id),
            (this.NeoClosest = response.data.NeoClosest),
            (this.asteroids_count_values =
              response.data.asteroids_count_values),
            (this.total_no_of_asteroid = response.data.asteroids_count),
            // console.log(response.data);
            this.getChart();
        })
        // .then((response) => console.log(response.data))
        .catch((err) => console.log(err));
    },
    getChart() {
      //   alert("function call to display chart");
      var tot_no_asteroids = this.total_no_of_asteroid;
      var asteroids_count_values = this.asteroids_count_values;
      console.log(tot_no_asteroids);
      console.log(asteroids_count_values);

      // plot the values on line graph
      var ctx = document.getElementById("neoChart").getContext("2d");
      var myChart = new Chart(ctx, {
        type: "line",
        data: {
          labels: tot_no_asteroids,
          datasets: [
            {
              label: "Total No of Asteroids",
              data: asteroids_count_values,
              //   backgroundColor: [
              //     "rgba(255, 99, 132, 0.2)",
              //     "rgba(54, 162, 235, 0.2)",
              //     "rgba(255, 206, 86, 0.2)",
              //     "rgba(75, 192, 192, 0.2)",
              //     "rgba(153, 102, 255, 0.2)",
              //     "rgba(255, 159, 64, 0.2)",
              //   ],
              borderColor: [
                "rgba(255, 99, 132, 1)",
                "rgba(54, 162, 235, 1)",
                "rgba(255, 206, 86, 1)",
                "rgba(75, 192, 192, 1)",
                "rgba(153, 102, 255, 1)",
                "rgba(255, 159, 64, 1)",
              ],
              borderWidth: 1,
            },
          ],
        },
      });
    },
  },
};
</script>


