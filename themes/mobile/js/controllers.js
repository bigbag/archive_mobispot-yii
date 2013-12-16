function MobileCtrl($scope, $http) {

    $scope.followSocial = function(service, param, idBlock)
    {
        var data = {service: service, param:param, token:$scope.token};
        var pathname = '/spot/';
        if (window.location.pathname.toLowerCase().indexOf('/mobile/spot') != -1)
            pathname = '/mobile/spot/';
        $http.post((pathname + 'FollowSocial'), data).success(function(data) {
            if (!data.LoggedIn)
            {

                window.location = 'http://' + window.location.hostname + pathname + 'SocLogin?service=' + service 
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