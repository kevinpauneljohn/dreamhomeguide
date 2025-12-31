<!--floating tools-->
<!-- Drawer Toggle Tab -->
<div id="tool-tab" title="Tools">
    <i class="fa-solid fa-gear"></i>

</div>

<div id="tool-drawer">
    <div class="drawer-header">
        <h6>Tools</h6>
        <button id="close-drawer" class="btn btn-light">&times;</button>
    </div>

    <div class="tool-grid">
        <div class="tool-app mb-2" data-tool="calculator">
            <i class="fa fa-calculator"></i>
            <span>Calculator</span>
        </div>

        <div class="tool-app mb-2" data-tool="computations">
            <i class="fa fa-chart-line"></i>
            <span>Computations</span>
        </div>

        <div class="tool-app mb-2" data-tool="requirements">
            <i class="fa fa-file-circle-check"></i>
            <span>Requirements</span>
        </div>

        <div class="tool-app mb-2" data-tool="commission">
            <i class="fa fa-coins"></i>
            <span>Commission</span>
        </div>

        <div class="tool-app mb-2" data-tool="pagibig">
            <i class="fa fa-comment-dots"></i>

            <span>Canned Message</span>
        </div>

        <div class="tool-app mb-2" data-tool="bank">
            <i class="fa-brands fa-facebook"></i>

            <span>Facebook</span>
        </div>
    </div>
</div>

<x-tools.calculator />


@pushonce('scripts')
    @vite('resources/js/component/floatingTools/floating-tools.js')
@endpushonce

