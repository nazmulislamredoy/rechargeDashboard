<script type="text/javascript">
   var special_interests = [{"label": "one", "value": 55},
        {"label": "two", "value": 20},
        {"label": "three", "value": 55}];

    $(function() {
        var w = 160, //width
        h = 160, //height
        r = 80, //radius
        color = ['#DC3812', '#3266CC', '#FE9900'];
        var data = Array();
        for (var i = 0; i < special_interests.length; i++) {
            data.push({"label": special_interests[i].value, "value": 1});
        }
        //data = [{"label": "one", "value": 1},
        //    {"label": "two", "value": 1},
        //    {"label": "three", "value": 1}];
        var vis = d3.select("#trafficYesterday")
                .append("svg:svg") //create the SVG element inside the <body>
                .data([data]) //associate our data with the document
                .attr("width", w) //set the width and height of our visualization (these will be attributes of the <svg> tag
                .attr("height", h)
                .append("svg:g") //make a group to hold our pie chart
                .attr("transform", "translate(" + r + "," + r + ")") //move the center of the pie chart from 0, 0 to radius, radius

        var arc = d3.svg.arc() //this will create <path> elements for us using arc data
                .outerRadius(r).startAngle(function(d) {
            return d.startAngle + Math.PI / 2;
        })
                .endAngle(function(d) {
                    return d.endAngle + Math.PI / 2;
                });
        ;

        var pie = d3.layout.pie() //this will create arc data for us given a list of values
                .value(function(d) {
                    return d.value;
                }); //we must tell it out to access the value of each element in our data array

        var arcs = vis.selectAll("g.slice") //this selects all <g> elements with class slice (there aren't any yet)
                .data(pie) //associate the generated pie data (an array of arcs, each having startAngle, endAngle and value properties)
                .enter() //this will create <g> elements for every "extra" data element that should be associated with a selection. The result is creating a <g> for every object in the data array
                .append("svg:g") //create a group to hold each slice (we will have a <path> and a <text> element associated with each slice)
                .attr("class", "slice"); //allow us to style things in the slices (like text)
//console.log(arcs[0][0]);
//console.log(vis.selectAll("g.slice")[0][0])
        for (var counter = 0; counter < special_interests.length; counter++) {
            arcs[0][counter].setAttribute("onclick", "display_interest_list(" + counter + ")");
        }


        arcs.append("svg:path")
                .attr("fill", function(d, i) {
                    return color[i];
                }) //set the color for each slice to be chosen from the color function defined above
                .attr("d", arc); //this creates the actual SVG path using the associated data (pie) with the arc drawing function

        arcs.append("svg:text") //add a label to each slice
                .attr("transform", function(d) { //set the label's origin to the center of the arc
//we have to make sure to set these before calling arc.centroid
                    d.innerRadius = 0;
                    d.outerRadius = r;
                    return "translate(" + arc.centroid(d) + ")"; //this gives us a pair of coordinates like [50, 50]
                })
                .attr("text-anchor", "middle") //center the text on it's origin
                .text(function(d, i) {
                    return data[i].label;
                }); //get the label from our original data array        
    });

</script>
<form>
    <div class="row">
        <div class="col-md-12">
            <div class="text-center padding_top_10px" id="trafficYesterday" ></div>
        </div>
    </div>
</form>
