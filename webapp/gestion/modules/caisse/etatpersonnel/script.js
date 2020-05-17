$(function(){

	
	var radarData = {
		labels: ["Eating", "Drinking", "Sleeping", "Designing", "Coding", "Cycling", "Running"],
		datasets: [
		{
			label: "Production",
			backgroundColor: "rgba(220,220,220,0.2)",
			borderColor: "rgba(220,220,220,1)",
			data: [65, 59, 90, 81, 56, 55, 40]
		},
		{
			label: "Livraison",
			backgroundColor: "rgba(26,179,148,0.2)",
			borderColor: "rgba(26,179,148,1)",
			data: [28, 48, 40, 19, 96, 27, 100]
		},
		{
			label: "Perte",
			backgroundColor: "rgba(105,179,148,0.2)",
			borderColor: "rgba(105,179,148,1)",
			data: [28, 48, 40, 19, 96, 27, 100]
		}
		]
	};

	var radarOptions = {
		responsive: true
	};

	var ctx5 = document.getElementById("radarChart").getContext("2d");
	new Chart(ctx5, {type: 'radar', data: radarData, options:radarOptions});


	

	var doughnutData = {
		labels: ["App","Software","Laptop" ],
		datasets: [{
			data: [300,50,100],
			backgroundColor: ["#a3e1d4","#dedede","#b5b8cf"]
		}]
	} ;


	var doughnutOptions = {
		responsive: false
	};


	var ctx4 = document.getElementById("doughnutChart").getContext("2d");
	new Chart(ctx4, {type: 'doughnut', data: doughnutData, options:doughnutOptions});


})