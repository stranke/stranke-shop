;(function(){
  function getTargetId(target) {
    if (!window.strankeConfig || !window.strankeConfig.targets) {
      return false;
    }

    var targetId = window.strankeConfig.targets[target];
    if (!targetId) {
      return false;
    }

    return targetId;
  }

  function getYaCounter() {
    for(var i in window){
      if(new RegExp(/yaCounter/).test(i)){
        return window[i];
      }
    }

    return false;
  }

  function addToBasketHandler() {
    var yaCounter = getYaCounter();
    if (!yaCounter) {
      return;
    }

    var targetId = getTargetId('ADD_TO_BASKET');
    if (!targetId) {
      return;
    }

    yaCounter.reachGoal(targetId);
  }

  function purchaseHandler() {
    var yaCounter = getYaCounter();
    if (!yaCounter) {
      return;
    }

    var targetId = getTargetId('ADD_TO_BASKET');
    if (!targetId) {
      return;
    }

    yaCounter.reachGoal(targetId);
  }

  window.addEventListener('addToBasket', addToBasketHandler, false);
  window.addEventListener('purchase', purchaseHandler, false);

  BX.addCustomEvent('target', function(e) {
    console.log(e);
  });

}());