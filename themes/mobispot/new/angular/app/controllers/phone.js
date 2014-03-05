'use strict';
angular.module('mobispot').controller('PhonesController', 
  function($scope) {
	$scope.initPhones = function(initValue)
	{
		$scope.parents = initValue;
		var herher = $scope.parents.models;
	}

	$scope.phonesList = [
		{ brand: 'Samsung',
			models: [{
					name : 'Ativ S',
					page : 'http://www.samsung.com/global/ativ/ativ_s.html',
					},
				{
					name : 'Galaxy Ace 2',
					page : 'http://www.samsung.com/uk/consumer/mobile-devices/smartphones/android/GT-I8160OKABTU'
				},
				{
					name : 'Galaxy Mini 2',
					page : 'http://www.samsung.com/hk_en/consumer/mobile/mobile-phones/smartphone/GT-S6500HADTGY'
				},
				{
					name : 'Galaxy Fame',
					page : '#'
				},
				{
					name : 'Galaxy Nexus',
					page : '#'
				},
				{
					name : 'Galaxy Note',
					page : '#'
				},
				{
					name : 'Galaxy Note II',
					page : '#'
				},
				{
					name : 'Galaxy Note 3',
					page : '#'
				},
				{
					name : 'Galaxy Rugby Pro',
					page : '#'
				},
				{
					name : 'Galaxy S Blaze 4G',
					page : '#'
				},
				{
					name : 'Galaxy S Advance',
					page : '#'
				},
				{
					name : 'Galaxy S II',
					page : '#'
				},
				{
					name : 'Galaxy S III',
					page : '#'
				},
				{
					name : 'Galaxy S Relay 4G',
					page : '#'
				},
				{
					name : 'Galaxy S 4',
					page : '#'
				},
				{
					name : 'S5230',
					page : '#'
				},
				{
					name : 'Wave 578',
					page : '#'
				},
				{
					name : 'Wave Y',
					page : '#'
				}
			],
			badModels: [{
				name : 'Wave Y',
				page : '#'
			},
			{
				name : 'Wave Y',
				page : '#'
			}

			]
		},
		{ brand: 'NOKIA',
			models: [
				{
					name : '603',
					page : '#'
				},
				{
					name : '700',
					page : '#'
				},
				{
					name : '701',
					page : '#'
				},
				{
					name : '808 PureView',
					page : 'http://www.nokia.com/global/products/phone/808pureview/'
				},
				{
					name : 'C7',
					page : '#'
				},
				{
					name : 'Lumia 610',
					page : '#'
				},
				{
					name : 'Lumia 620',
					page : '#'
				},
				{
					name : 'Lumia 720',
					page : '#'
				},
				{
					name : 'Lumia 810',
					page : '#'
				},
				{
					
					name : 'Lumia 820',
					page : '#'
				},
				{
					name : 'Lumia 822',
					page : '#'
				},
				{
					name : 'Lumia 920',
					page : 'http://www.nokia.com/global/products/phone/lumia920/'
				},
				{
					name : 'Lumia 925',
					page : '#'
				},
				{
					name : 'Lumia 928',
					page : '#'
				},
				{
					name : 'Lumia N9',
					page : '#'
				}

			]
		},
		{ brand: 'Sony',
			models: [
				{
					name : 'Xperia Acro S',
					page : '#'
				},
				{
					name : 'Xperia Ion',
					page : '#'
				},
				{
					name : 'Xperia L',
					page : '#'
				},
				{
					name : 'Xperia S',
					page : '#'
				},
				{
					name : 'Xperia Sola',
					page : '#'
				},
				{
					name : 'Xperia SP',
					page : '#'
				},
				{
					name : 'Xperia P',
					page : '#'
				},
				{
					name : 'Xperia T',
					page : '#'
				},
				{
					name : 'Xperia V',
					page : '#'
				},
				{
					name : 'Xperia Z',
					page : '#'
				},
				{
					name : 'Xperia ZL',
					page : '#'
				}
			]
		},
		{ brand: 'Google',
			models: [
				{
					name : 'Nexus 4',
					page : '#'
				},
				{
					name : 'Nexus S',
					page : '#'
				}
			]
		},
		{ brand: 'Motorola',
			models: [
				{
					name : 'Razr HD',
					page : '#'
				},
				{
					name : 'Razr M',
					page : '#'
				},
				{
					name : 'Photon Q',
					page : '#'
				},
				{
					name : 'Razr I',
					page : '#'
				},
				{
					name : 'Razr D1',
					page : '#'
				}
			]
		},
		{ brand: 'LG',
			models: [
				{
					name : 'Optimus 3D Max',
					page : '#'
				},
				{
					name : 'Optimus G',
					page : '#'
				},
				{
					name : 'Optimus G Pro',
					page : '#'
				},
				{
					name : 'Optimus 4X HD',
					page : '#'
				},
				{
					name : 'Optimus L5',
					page : '#'
				},
				{
					name : 'Optimus L7',
					page : '#'
				},
				{
					name : 'Optimus L9',
					page : '#'
				},
				{
					name : 'Optimus LTE',
					page : '#'
				},
				{
					name : 'Optimus Vu',
					page : '#'
				},
				{
					name : 'Optimus Vu 2',
					page : '#'
				}
			]
		},
		{ brand: 'HTC',
			models: [
				{
					name : 'Nexus 4',
					page : '#'
				},
				{
					name : 'Nexus S',
					page : '#'
				}
			]
		}

	];

	$scope.devicesList = [
		{ brand: 'Yarus',
			models: [{
					name : 'T2100',
					page : '#',
					},
				{
					name : 'C2100',
					page : '#'
				}
			]
		},
		{ brand: 'Gigateck',
			models: [
				{
					name : 'MF7',
					page : '#'
				}
			]
		},
		{ brand: 'ACS',
			models: [
				{
					name : 'ACR122U',
					page : '#'
				},
				{
					name : 'ACR122S',
					page : '#'
				},
				{
					name : 'ACR1251',
					page : '#'
				}
			]
		}
	];
});
