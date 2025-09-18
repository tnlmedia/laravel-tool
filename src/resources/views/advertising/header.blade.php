@if ($gam_status)
  <script>
    @if ($gam_status)
      window.googletag = window.googletag || {cmd: []};
    @endif
  </script>
@endif
@if ($gam_status)
  <script async src="https://securepubads.g.doubleclick.net/tag/js/gpt.js"></script>
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
      googletag.pubads().addEventListener('{{ $item[0] ?? '' }}', function (event) {window.{{ $item[1] ?? '' }}(event);});
      @endforeach
      @endif
      googletag.enableServices();
    });
  </script>
@endif
@if ($gam_status)
  <script>
    window.tmgad = {
      serial: 0,
      loaded: false,
      scan: function () {
        googletag.cmd.push(function () {
          let list = document.querySelectorAll('.tmgad-new');
          for (let i = 0; i < list.length; i++) {
            tmgad.build(list[i]);
          }
        });
        if (!tmgad.loaded) {
          document.addEventListener('DOMContentLoaded', function () {
            tmgad.scan();
          });
          tmgad.loaded = true;
        }
      },
      build: function (target) {
        if (!target.classList.contains('tmgad-new')) {
          console.log('TMGAD build: Pass ' + target.getAttribute('class'));
          return;
        }
        try { target.classList.remove('tmgad-new'); } catch (e) {}
        let attributes = {id: '', name: '', slot: '', type: 'general', size: [], mapping: [], targeting: {}};
        try {
          attributes = Object.assign(attributes, JSON.parse(target.querySelector('script').textContent.trim()));
          tmgad.serial++;
          attributes.id = 'tmgad-' + attributes.name + '-' + tmgad.serial;
          target.setAttribute('id', attributes.id);
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
            for (let targeting in attributes.targeting) {
              if (!attributes.targeting[targeting].length) {
                continue;
              }
              slot.setTargeting(targeting, attributes.targeting[targeting]);
            }
            googletag.display(attributes.id);
            googletag.pubads().refresh([slot]);
          });
        } catch (e) {
          console.warn('TMGAD build: [' + attributes.id + ']' + e.message);
          return false;
        }
      },
    };
  </script>
@endif
