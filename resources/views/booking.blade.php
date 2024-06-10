<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Bootstrap demo</title>
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
      rel="stylesheet"
      integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH"
      crossorigin="anonymous"
    />
    <link
      href="https://cdn.jsdelivr.net/npm/remixicon@4.2.0/fonts/remixicon.css"
      rel="stylesheet"
    />
    <link rel="stylesheet" href="Booking.css" />
    <script src="https://cdn.tailwindcss.com"></script>
  </head>
  <body>
    <div class="header curved">
      <div class="logo ml-40"></div>
    </div>
    <form id="select" name="select" class="ml-40 my-40">
      <div class="grid grid-cols-1 mx-auto">
        <div class="flex items-center">
          <div class="w-24 md:w-32 text-lg">Event</div>
          <div class="text-lg">
            Mentoring Skills placement 2 Placement 2 mentors only (Primary)
          </div>
        </div>
        <div class="flex items-center">
          <div class="w-24 md:w-32 text-lg">Venue</div>
          <div class="text-lg text-balance">Online</div>
        </div>
        <div class="flex items-center">
          <div class="w-24 md:w-32 text-lg">Date</div>
          <div class="text-lg">Thursday 18th April 2024, 4:00PM - 5:00PM</div>
        </div>
        <div class="flex items-center">
          <div class="w-24 md:w-32 text-lg">Section</div>
          <div class="text-lg">General Admission</div>
        </div>
      </div>

      <section class="mt-8">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
          <div class="flex items-center">
            <strong class="text-lg"
              >Select the number of places you want to book from the available
              choices</strong
            >
          </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 mt-4">
          <div class="flex items-center space-between">
            <div class="flex items-center">
              <div class="w-24 md:w-32 text-lg">Places</div>
              <div class="w-48 md:w-64 space-x-40 text-lg">Free</div>
            </div>
          </div>
          <div class="flex items-center ml-[17.5rem]">
            <div class="flex items-center mr-6">
              <span class="text-lg">£0.00</span>
            </div>
            <div class="flex items-center space-x-4">
              <select
                name="seatingSectionPricingSelectionCount[]"
                id="seatingSectionPricingSelectionCount0"
                data-seatcount="1"
                data-price="0"
                data-mandatoryinfo="1"
                class="border border-gray-300 rounded-md px-3 py-1 mr-4"
              >
                <option value="0" selected="">0</option>
                <option value="1">1</option>
                <option value="2">2</option>
                <option value="3">3</option>
                <option value="4">4</option>
                <option value="5">5</option>
                <option value="6">6</option>
                <option value="7">7</option>
                <option value="8">8</option>
                <option value="9">9</option>
                <option value="10">10</option>
                <option value="11">11</option>
                <option value="12">12</option>
                <option value="13">13</option>
                <option value="14">14</option>
                <option value="15">15</option>
                <option value="16">16</option>
                <option value="17">17</option>
                <option value="18">18</option>
                <option value="19">19</option>
                <option value="20">20</option>
                <option value="21">21</option>
                <option value="22">22</option>
                <option value="23">23</option>
                <option value="24">24</option>
                <option value="25">25</option>
                <option value="26">26</option>
                <option value="27">27</option>
                <option value="28">28</option>
                <option value="29">29</option>
                <option value="30">30</option>
                <option value="31">31</option>
                <option value="32">32</option>
                <option value="33">33</option>
                <option value="34">34</option>
                <option value="35">35</option>
                <option value="36">36</option>
                <option value="37">37</option>
                <option value="38">38</option>
                <option value="39">39</option>
                <option value="40">40</option>
                <option value="41">41</option>
                <option value="42">42</option>
                <option value="43">43</option>
                <option value="44">44</option>
                <option value="45">45</option>
                <option value="46">46</option>
                <option value="47">47</option>
                <option value="48">48</option>
                <option value="49">49</option>
                <option value="50">50</option>
                <option value="51">51</option>
                <option value="52">52</option>
                <option value="53">53</option>
                <option value="54">54</option>
                <option value="55">55</option>
                <option value="56">56</option>
                <option value="57">57</option>
                <option value="58">58</option>
                <option value="59">59</option>
                <option value="60">60</option>
                <option value="61">61</option>
                <option value="62">62</option>
                <option value="63">63</option>
                <option value="64">64</option>
                <option value="65">65</option>
                <option value="66">66</option>
                <option value="67">67</option>
                <option value="68">68</option>
                <option value="69">69</option>
                <option value="70">70</option>
                <option value="71">71</option>
                <option value="72">72</option>
                <option value="73">73</option>
                <option value="74">74</option>
                <option value="75">75</option>
                <option value="76">76</option>
                <option value="77">77</option>
                <option value="78">78</option>
                <option value="79">79</option>
                <option value="80">80</option>
                <option value="81">81</option>
                <option value="82">82</option>
                <option value="83">83</option>
                <option value="84">84</option>
                <option value="85">85</option>
                <option value="86">86</option>
                <option value="87">87</option>
                <option value="88">88</option>
                <option value="89">89</option>
                <option value="90">90</option>
                <option value="91">91</option>
                <option value="92">92</option>
                <option value="93">93</option>
                <option value="94">94</option>
                <option value="95">95</option>
                <option value="96">96</option>
                <option value="97">97</option>
                <option value="98">98</option>
                <option value="99">99</option>
                <option value="100">100</option>
                <option value="101">101</option>
                <option value="102">102</option>
                <option value="103">103</option>
                <option value="104">104</option>
                <option value="105">105</option>
                <option value="106">106</option>
                <option value="107">107</option>
                <option value="108">108</option>
                <option value="109">109</option>
                <option value="110">110</option>
                <option value="111">111</option>
                <option value="112">112</option>
                <option value="113">113</option>
                <option value="114">114</option>
                <option value="115">115</option>
                <option value="116">116</option>
                <option value="117">117</option>
                <option value="118">118</option>
                <option value="119">119</option>
                <option value="120">120</option>
                <option value="121">121</option>
                <option value="122">122</option>
                <option value="123">123</option>
                <option value="124">124</option>
                <option value="125">125</option>
                <option value="126">126</option>
                <option value="127">127</option>
                <option value="128">128</option>
                <option value="129">129</option>
                <option value="130">130</option>
                <option value="131">131</option>
                <option value="132">132</option>
                <option value="133">133</option>
                <option value="134">134</option>
                <option value="135">135</option>
                <option value="136">136</option>
                <option value="137">137</option>
                <option value="138">138</option>
                <option value="139">139</option>
                <option value="140">140</option>
                <option value="141">141</option>
                <option value="142">142</option>
                <option value="143">143</option>
                <option value="144">144</option>
                <option value="145">145</option>
                <option value="146">146</option>
                <option value="147">147</option>
                <option value="148">148</option>
                <option value="149">149</option>
                <option value="150">150</option>
                <option value="151">151</option>
                <option value="152">152</option>
                <option value="153">153</option>
                <option value="154">154</option>
                <option value="155">155</option>
                <option value="156">156</option>
                <option value="157">157</option>
                <option value="158">158</option>
                <option value="159">159</option>
                <option value="160">160</option>
                <option value="161">161</option>
                <option value="162">162</option>
                <option value="163">163</option>
                <option value="164">164</option>
                <option value="165">165</option>
                <option value="166">166</option>
                <option value="167">167</option>
                <option value="168">168</option>
                <option value="169">169</option>
                <option value="170">170</option>
                <option value="171">171</option>
                <option value="172">172</option>
                <option value="173">173</option>
                <option value="174">174</option>
                <option value="175">175</option>
                <option value="176">176</option>
                <option value="177">177</option>
                <option value="178">178</option>
                <option value="179">179</option>
                <option value="180">180</option>
                <option value="181">181</option>
                <option value="182">182</option>
                <option value="183">183</option>
                <option value="184">184</option>
                <option value="185">185</option>
                <option value="186">186</option>
                <option value="187">187</option>
                <option value="188">188</option>
                <option value="189">189</option>
                <option value="190">190</option>
                <option value="191">191</option>
                <option value="192">192</option>
                <option value="193">193</option>
                <option value="194">194</option>
                <option value="195">195</option>
                <option value="196">196</option>
                <option value="197">197</option>
                <option value="198">198</option>
                <option value="199">199</option>
                <option value="200">200</option>
                <option value="201">201</option>
                <option value="202">202</option>
                <option value="203">203</option>
                <option value="204">204</option>
                <option value="205">205</option>
                <option value="206">206</option>
                <option value="207">207</option>
                <option value="208">208</option>
                <option value="209">209</option>
                <option value="210">210</option>
                <option value="211">211</option>
                <option value="212">212</option>
                <option value="213">213</option>
                <option value="214">214</option>
                <option value="215">215</option>
                <option value="216">216</option>
                <option value="217">217</option>
                <option value="218">218</option>
                <option value="219">219</option>
                <option value="220">220</option>
                <option value="221">221</option>
                <option value="222">222</option>
                <option value="223">223</option>
                <option value="224">224</option>
                <option value="225">225</option>
                <option value="226">226</option>
                <option value="227">227</option>
                <option value="228">228</option>
                <option value="229">229</option>
                <option value="230">230</option>
                <option value="231">231</option>
                <option value="232">232</option>
                <option value="233">233</option>
                <option value="234">234</option>
                <option value="235">235</option>
                <option value="236">236</option>
                <option value="237">237</option>
                <option value="238">238</option>
                <option value="239">239</option>
                <option value="240">240</option>
                <option value="241">241</option>
                <option value="242">242</option>
                <option value="243">243</option>
                <option value="244">244</option>
                <option value="245">245</option>
                <option value="246">246</option>
                <option value="247">247</option>
                <option value="248">248</option>
                <option value="249">249</option>
                <option value="250">250</option>
              </select>
            </div>
            <div class="text-right space-x-4">
              <span>=</span>
              <span id="seatingSectionPricingLineTotalAmount0"> £0.00</span>
            </div>
          </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4 d-none">
          <div class="flex items-center md:col-span-2">
            <div class="w-24 md:w-32 font-semibold"></div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
              <div class="flex items-center">
                <div class="text-gray-600">
                  <small>Password required</small>
                </div>
                <div class="ml-2">Mentor Password</div>
              </div>
              <div class="flex items-center space-x-4">
                <input
                  type="text"
                  name="seatingSectionPricingMandatoryInfoValue[]"
                  id="seatingSectionPricingMandatoryInfoValue0"
                  maxlength="7"
                  class="border border-gray-300 rounded-md px-3 py-1"
                />
              </div>
            </div>
          </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
          <div class="flex items-center md:col-span-2">
            <div class="w-24 md:w-30 font-semibold">Booking total</div>
            <div class="text-center pl-[38rem]">
              <span
                id="transTotalPrice"
                class="font-semibold px-12 text-center border-t-[2px]"
                >£0.00</span
              >
            </div>
          </div>
        </div>
      </section>
    </form>

    <nav
      class="navbar navbar-expand-lg sticky-bottom-navbar d-flex py-2 px-40 align-items-end justify-content-end gap-2"
    >
      <a href="/Album.html" class="event-btn">Back</a>
      <a href="#" class="event-btn">Next</a>
    </nav>
  </body>

  <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/1.20.2/TweenMax.min.js"></script>

  <script
    src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
    crossorigin="anonymous"
  ></script>
</html>
