app.controller("recipesController", function($scope, $http){
	
	//todas las recetas:
	$scope.recipes = [];
	//recetas semalaes
	$scope.weekSchedule = [];
	
	$scope.init = function() {
	
		//coge tods las recetas:
		$http.get('assets/angular-app/json/recetas.json').success(function(data) {
	    	$scope.recipes = data;
		    //ultima id del json de recetas, de cara a añadir recetas
		    $scope.lastRecipeId = data[data.length-1].id;
	    });
	    
	    //coge las recetas de la semana si hay:
	    $http.get('assets/angular-app/json/recetaSemanal.json').success(function(data) {
	    	$scope.weekSchedule = data;
	    });
	    
	};
	
	$scope.randIt = function() {
	
		//las 7 receas elegidas para la vista:
		$scope.recipesChoosen = [];
		//para que no almacenar más de una vez la misma receta
		var idChoosen = [];
		var n=1
	
		while(n<=7){
			
			//numro aleatorio de 1 a la longitud del array de recetas:
			var idRand = Math.floor(Math.random() * $scope.recipes.length) + 1;
			idChoosen.push(idRand);
			
			//condición que comprueba que es areceta no se ha elegido: si el id de la receta no está almacenado exactamente en la última posicion del array idChoosen, es que ha salido antes.
			var notFound = idChoosen.indexOf(idRand) == (idChoosen.length - 1);
			
			//consultamso que esa receta (id) no haya salido ya en este bucle semanal:
			if(notFound){
				$scope.recipesChoosen.push($scope.recipes[idRand-1]);
				n++;
			}
		
		}
		
	};
	
	$scope.storeIt = function()	{
	
		//la vaciamos
		$scope.weekSchedule = [];
		//volcar array:
		$scope.weekSchedule = $scope.recipesChoosen.slice(0);
		
		$http({
		    url: "assets/angular-app/controllers/storeIt.php",
		    method: "POST",
		    data: $scope.weekSchedule
		}).success(function(data, status, headers, config) {
		    $scope.data = data;
		}).error(function(data, status, headers, config) {
		    $scope.status = status;
		    console.log($scope.status);
		});

	};
	
	$scope.showIngredients = function(id) {
	
		$scope.recipeName = $scope.recipes[id-1].name;
		$scope.ingredients = [];
		$scope.ingredients = $scope.recipes[id-1].ingredients.split(',');
		
	};
	
	$scope.shoppingList = function() {
		
		$scope.shoppingList = [];
		$scope.shoppingListIngredients = [];
		
		for(var i=0;i<$scope.weekSchedule.length;i++) {
			$scope.shoppingList.push($scope.weekSchedule[i].ingredients.split(','));
		}
		
		for(var j=0;j<$scope.shoppingList.length;j++) {
			for(var k=0;k<$scope.shoppingList[j].length;k++) {
				var ingredient = $scope.shoppingList[j][k];
				var notFound = $scope.shoppingListIngredients.indexOf(ingredient) == -1;
				if(notFound) $scope.shoppingListIngredients.push(ingredient);
			}
		}
		
	}
	
});