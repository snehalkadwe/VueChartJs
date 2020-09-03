<template>
  <div class="container text-center mt-2">
    <h5>Select start and end date to find nearest astroid between dates</h5>
    <form action v-on:submit.prevent="getData()">
      <div class="row mt-3 p-2">
        <div class="col md-4 text-center">
          <div class="form-group row">
            <label for="startDate" class="col-sm-4 col-form-label">Start Date</label>
            <div class="col-sm-8">
              <vuejs-datepicker
                placeholder="Select Start date"
                format="dd/MM/yyyy"
                :clear-button="true"
                v-model="start_date"
                @closed="DateChecker()"
              ></vuejs-datepicker>
            </div>
          </div>
        </div>
        <div class="col-md-4">
          <div class="form-group row">
            <label for="endDate" class="col-sm-4 col-form-label">End Date</label>
            <div class="col-sm-8">
              <vuejs-datepicker
                placeholder="select end date"
                format="dd/MM/yyyy"
                :clear-button="true"
                v-model="end_date"
                @closed="DateChecker()"
              ></vuejs-datepicker>
            </div>
          </div>
        </div>
        <div class="col-md-4">
          <div class="input-group-append">
            <button class="btn btn-secondary" type="submit">Submit</button>
          </div>
        </div>
      </div>
      total no of asteroids: {{ no_asteroid }}
      <table class="table">
        <tr>
          <th>Sr</th>
          <th>Fastest Asteroid in km/h</th>
          <th>Average Size in km/h</th>
        </tr>

        <tr v-for="(asteroid, index) in NEOarray" v-bind:key="asteroid.id">
          <td>{{ index }}</td>
          <td>neo id = {{ asteroid.neo_reference_id }}</td>
          <td>{{asteroid.estimated_diameter.kilometers.estimated_diameter_max}}</td>
        </tr>
      </table>
      <br />
    </form>
    <canvas id="myChart"></canvas>
  </div>
</template>

<script>
import Chart from "chart.js";
import moment from "moment";

export default {
  data() {
    return {
      chart: null,
      start_date: null,
      end_date: null,
      NEOarray: [],
      no_asteroid: "",
    };
  },
  // created: function() {
  //     this.getData();
  // },
  methods: {
    DateChecker: function () {
      if (this.start_date != "" && this.end_date != "") {
        var start_date = this.start_date;
        var end_date = this.end_date;
        // console.log(start_date);
        // console.log(end_date);
      }
    },
    getData() {
      if (this.start_date != "" && this.end_date != "") {
        const start_date = moment(this.start_date, "YYYYMMDD").format(
          "YYYY/MM/DD"
        );
        const end_date = moment(this.end_date, "YYYYMMDD").format("YYYY/MM/DD");
        const start_day = moment(this.start_date, "YYYYMMDD").format("DD");
        const end_day = moment(this.end_date, "YYYYMMDD").format("DD");
        // console.log(start_date);
        // console.log(end_date);
        // console.log(start_day);
        // console.log(end_day);
        let startNum = Number(start_day);
        let endNum = Number(end_day);
        let total_Days = endNum - startNum + 1;
        // console.log(startNum);
        // console.log(endNum);
        // console.log(total_Days);

        var neo_output = axios
          .get(`https://api.nasa.gov/neo/rest/v1/feed/`, {
            params: {
              start_date: this.start_date,
              end_date: this.end_date,
              api_key: "Oz1JxpM5e8beyAD8PlKIUh93WRhIUXMWXHIfb5Mr",
              feedtype: "json",
            },
          })

          .then((response) => {
            this.no_asteroid = response.data.element_count;
            console.log(this.no_asteroid);

            // this.lists = response.data.near_earth_objects;
            let lists = response.data.near_earth_objects;
            // console.log(response.data.near_earth_objects);

            for (var count = 0; count < total_Days; count++) {
              var NEOarray = lists[Object.keys(lists)[count]];
              var NEOclose = NEOarray[Object.keys(NEOarray)[0]];
              var neo_close_app = NEOclose.close_approach_data;
              var neo_close_appDate =
                neo_close_app[Object.keys(neo_close_app)[0]];
              var capString = neo_close_appDate.close_approach_date;

              console.log((this.NEOarray = NEOarray));
              //   console.log(NEOclose);
              //   console.log(neo_close_app);
              //   console.log(neo_close_appDate);
              //   console.log(capString);
              //   console.log(count);
              for (
                var index = 0;
                index < NEOarray.length, NEOclose.length;
                index++
              ) {
                console.log(NEOarray[index].name);
              }
            }
            var ctx = document.getElementById("myChart");
            this.chart = new Chart(ctx, {
              type: "line",
              data: {
                labels: this.total_Days,
                datasets: [
                  {
                    label: "near_earth_objects",
                    data: capString,
                    backgroundColor: "rgba(54, 162, 235, 0.5)",
                    borderColor: "rgb(54, 162, 235)",
                    fill: false,
                  },
                ],
              },
              options: {
                title: {
                  display: true,
                  text: "asteroids data",
                },
              },
            });
          })
          .catch((error) => {
            console.log(error);
            this.errored = true;
          });
      } //if end
    },
  },
  components: {
    vuejsDatepicker,
  },
};
</script>
