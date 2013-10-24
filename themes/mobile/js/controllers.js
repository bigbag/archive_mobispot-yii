function MobileCtrl($scope, $http) {

    $scope.followSocial = function(service, param, idBlock)
    {
        var data = {service: service, param:param, token:$scope.token};
        $http.post('/mobile/spot/FollowSocial', data).success(function(data) {
            if (!data.LoggedIn)
            {
                window.location = 'http://' + window.location.hostname + '/mobile/spot/SocLogin?service=' + service 
                                    + '&return_url=' 
                                    + escape(window.location.hostname + window.location.pathname + window.location.search) 
                                    + '&follow_param=' + escape(param);
            }
            else if (data.error == 'no' && typeof (data.message) != 'undefined')
            {
                angular.element('#' + idBlock + ' a.spot-button.soc-link').text(data.message);
            }
        });
    }
}