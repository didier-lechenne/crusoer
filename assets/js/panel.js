(() => {
  if (!('BroadcastChannel' in window)) return;
  if (!window.panel || !window.panel.events) return;

  const channel = new BroadcastChannel('crusoer-reload-on-save');

  window.panel.events.on('model.update', () => {
    channel.postMessage('content/saved');
  });
})();
