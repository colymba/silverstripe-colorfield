<input $AttributesHTML data-config="$JSConfig" />
$Controls.Proxy
<div class="colorFieldPreview">
  <div class="color" style="background-color:#{$Color.Hex};opacity:$Color.A;"></div>
</div>
<div class="colorFieldControls field dropdown text">
  <span class="mode">$Controls.Mode</span>

  <span class="hex">
    <label class="left" for="$Controls.Hex.ID">Hex</label>
    $Controls.Hex
  </span>
  
  <span class="rgb">
    <label class="left" for="$Controls.Red.ID">R</label> $Controls.Red
    <label class="left" for="$Controls.Green.ID">G</label> $Controls.Green
    <label class="left" for="$Controls.Blue.ID">B</label> $Controls.Blue
  </span>

  <% if $Options.Alpha %>
    <span class="alpha">
      <label class="left" for="$Controls.Alpha.ID">Alpha</label>
      $Controls.Alpha
    </span>
  <% end_if %>
</div>