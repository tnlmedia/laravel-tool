@if ($gam_status || $flux_status)
  <script>
    @if ($flux_status)
      window.pbjs = window.pbjs || {que: []};
    @endif
      @if ($gam_status)
      window.googletag = window.googletag || {cmd: []};
    @endif
  </script>
@endif
@if ($flux_core)
  <script async src="{{ $flux_core }}"></script>
@endif
@if ($gam_status)
  <script async src="https://securepubads.g.doubleclick.net/tag/js/gpt.js"></script>
@endif
@if ($flux_status)
  <script>
    window.fluxtag = {
      readyBids: {prebid: false, amazon: false, google: false},
      failSafeTimeout: {{ $flux_timeout }},
      isFn: function (object) {
        var _t = 'Function';
        var toString = Object.prototype.toString;
        return toString.call(object) === '[object ' + _t + ']';
      },
      launchAdServer: function () {
        if (!fluxtag.readyBids.prebid || !fluxtag.readyBids.amazon) {
          return;
        }
        fluxtag.requestAdServer();
      },
      requestAdServer: function () {
        if (!fluxtag.readyBids.google) {
          fluxtag.readyBids.google = true;
          googletag.cmd.push(function () {
            if (!!(pbjs.setTargetingForGPTAsync) && fluxtag.isFn(pbjs.setTargetingForGPTAsync)) {
              pbjs.que.push(function () { pbjs.setTargetingForGPTAsync(); });
            }
            googletag.pubads().refresh();
          });
        }
      },
      renderAds: function (lines, failSafeTimeout) {
        googletag.cmd.push(function () {
          var failSafeTimeout = failSafeTimeout || window.fluxtag.failSafeTimeout;
          var bidRequestTimeout = (failSafeTimeout - 500) > 0 ? failSafeTimeout - 500 : failSafeTimeout;
          var refreshLines = [];
          var params = (function () {
            var readyBids = {amazon: false, google: false, prebid: false};
            var definedSlots = [];
            var adsInfo = {
              gpt: {slots: [], displayDivIds: []},
              aps: {slots: [], divIds: []},
              pb: {divIds: []},
            };
            var getSizeList = function (width, height, sizeMappings) {
              const sizeMapping = sizeMappings.filter(function (mappingObject) {
                return mappingObject[0][0] <= width && mappingObject[0][1] <= height;
              }).reduce(function (a, b) {
                return (Math.abs(b[0][0] - width) <= Math.abs(a[0][0] - width) && Math.abs(b[0][1] - height) <= Math.abs(a[0][1] - height)) ? b : a;
              });
              if (!sizeMapping[1].length) {
                sizeMapping[1].push([]);
              }
              return sizeMapping[1];
            };
            googletag.pubads().getSlots().forEach(function (slot) {
              definedSlots[slot.getSlotElementId()] = slot;
            });
            lines.forEach(function (line) {
              var divId = line.divId;
              adsInfo.pb.divIds.push(divId);
              refreshLines.push({code: line.gpt.unitCode, id: divId});
              if (definedSlots[divId]) {
                adsInfo.gpt.slots.push(definedSlots[divId]);
              } else {
                var slot = googletag.defineSlot(line.gpt.unitCode, line.gpt.sizes, divId).addService(googletag.pubads());
                if (line.gpt.sizeMapping && line.gpt.sizeMapping.length > 0) {
                  var sizeMapping = googletag.sizeMapping();
                  line.gpt.sizeMapping.forEach(function (size) {
                    sizeMapping.addSize(size[0], size[1]);
                  });
                  slot.defineSizeMapping(sizeMapping.build());
                }
                if (line.gpt.keyValues && line.gpt.keyValues.length > 0) {
                  line.gpt.keyValues.forEach(function (param) {
                    slot.setTargeting(param.key, param.value);
                  });
                }
                adsInfo.gpt.slots.push(slot);
                adsInfo.gpt.displayDivIds.push(divId);
              }
              if (!!line.aps) {
                if (line.gpt.sizeMapping && line.gpt.sizeMapping.length > 0) {
                  line.aps.sizes = getSizeList(window.innerWidth, window.innerHeight, line.gpt.sizeMapping);
                }
                adsInfo.aps.slots.push({
                  slotID: divId,
                  slotName: line.aps.slotName,
                  sizes: line.aps.sizes,
                });
                adsInfo.aps.divIds.push(divId);
              }
            });
            if (adsInfo.aps.slots.length === 0) {
              readyBids.amazon = true;
            }
            var adServerSend = function () {
              if (!readyBids.amazon || !readyBids.prebid) {
                return;
              }
              if (!readyBids.google) {
                readyBids.google = true;
                adsInfo.gpt.displayDivIds.forEach(function (divId) {
                  googletag.display(divId);
                });
                if (!!(pbjs.setTargetingForGPTAsync) && fluxtag.isFn(pbjs.setTargetingForGPTAsync)) {
                  pbjs.que.push(function () {
                    pbjs.setTargetingForGPTAsync(adsInfo.pb.divIds);
                  });
                }
                if (adsInfo.aps.slots.length > 0 && !!(window.apstag) && fluxtag.isFn(window.apstag.fetchBids)) {
                  window.apstag.setDisplayBids(adsInfo.aps.divIds);
                }
                googletag.pubads().refresh(adsInfo.gpt.slots);
              }
            };
            var apsCallback = function () {
              readyBids.amazon = true;
              adServerSend();
            };
            var pbCallback = function () {
              readyBids.prebid = true;
              adServerSend();
            };
            setTimeout(function () {
              readyBids.amazon = true;
              readyBids.prebid = true;
              adServerSend();
            }, failSafeTimeout);
            return {aps: {slots: adsInfo.aps.slots, callback: apsCallback}, prebid: {callback: pbCallback}};
          })();
          if (!!(window.pbFlux) && window.pbFlux.refresh && fluxtag.isFn(window.pbFlux.refresh)) {
            pbjs.que.push(function () {
              window.pbFlux.refresh({
                lines: refreshLines,
                callback: params.prebid.callback,
                timeout: bidRequestTimeout,
              });
            });
          } else {
            params.prebid.callback();
          }
          if (params.aps.slots.length > 0 && !!(window.apstag) && fluxtag.isFn(window.apstag.fetchBids)) {
            window.apstag.fetchBids({
              slots: params.aps.slots,
              timeout: bidRequestTimeout,
            }, function (bids) { params.aps.callback(); });
          } else {
            params.aps.callback();
          }
        });
      },
    };
  </script>
@endif
@if ($gam_status)
  <script>
    googletag.cmd.push(function () {
      googletag.pubads().enableSingleRequest();
      googletag.pubads().disableInitialLoad();
      googletag.pubads().enableAsyncRendering();
      googletag.pubads().collapseEmptyDivs();
      @if (is_array($gam_event))
        @foreach ($gam_event as $item)
          window.{{ $item[1] ?? '' }} = window.{{ $item[1] ?? '' }} || function (event) {};
          googletag.pubads().addEventListener('{{ $item[0] ?? '' }}', {{ $item[1] ?? '' }});
        @endforeach
      @endif
      googletag.enableServices();
    });
  </script>
@endif
@if ($gam_status || $flux_status)
  <script>
    window.tmgad = {
      serial: 0,
      loaded: false,
      scan: function () {
        let list = document.querySelectorAll('.tmgad-new');
        let i;
        for (i = 0; i < list.length; i++) {
          tmgad.build(list[i]);
        }
        if (!tmgad.loaded) {
          document.addEventListener('DOMContentLoaded', function () {
            tmgad.scan();
          });
          tmgad.loaded = true;
        }
      },
      build: function (target) {
        try { target.classList.remove('tmgad-new'); } catch (e) {}
        let attributes = {id: '', name: '', slot: '', type: 'general', size: [], mapping: [], targeting: {}};
        try {
          attributes = Object.assign(attributes, JSON.parse(target.querySelector('script').textContent.trim()));
          tmgad.serial++;
          attributes.id = 'tmgad-' + attributes.name + '-' + tmgad.serial;
          target.setAttribute('id', attributes.id);
          switch (attributes.type) {
            case 'flux':
              let flux = {
                divId: attributes.id,
                gpt: {
                  unitCode: attributes.slot,
                  sizes: attributes.size,
                  sizeMapping: attributes.mapping,
                  keyValues: [],
                },
              };
              for (let targeting in attributes.targeting) {
                if (!attributes.targeting[targeting].length) {
                  continue;
                }
                flux.gpt.keyValues.push({key: targeting, value: attributes.targeting[targeting]});
              }
              window.fluxtag.renderAds([flux]);
              return;
          }
          let mapping = googletag.sizeMapping();
          for (let i = 0; i < attributes.mapping.length; i++) {
            if (!attributes.mapping[i][1].length) {
              continue;
            }
            mapping = mapping.addSize(attributes.mapping[i][0], attributes.mapping[i][1]);
          }
          let service = googletag.pubads();
          for (let targeting in attributes.targeting) {
            if (!attributes.targeting[targeting].length) {
              continue;
            }
            service.setTargeting(targeting, attributes.targeting[targeting]);
          }
          googletag.cmd.push(function () {
            let slot;
            switch (attributes.type) {
              case 'oop':
                slot = googletag.defineOutOfPageSlot(attributes.slot, attributes.id)
                  .addService(service);
                break;
              default:
                slot = googletag.defineSlot(attributes.slot, attributes.size, attributes.id)
                  .defineSizeMapping(mapping.build()).addService(service);
                break;
            }
            googletag.display(attributes.id);
            googletag.pubads().refresh([slot]);
          });
        } catch (e) {
          console.warn('TMGAD build: ' + e.message);
          return false;
        }
      },
    };
  </script>
@endif
