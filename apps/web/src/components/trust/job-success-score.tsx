import { Info } from "lucide-react";
import { cn } from "@/lib/utils";
import type { JobSuccessScoreComponents } from "@/lib/job-success-score";

interface JobSuccessScoreProps {
  score: number | null;
  components?: JobSuccessScoreComponents;
  size?: "sm" | "md" | "lg";
  className?: string;
}

const SIZES = {
  sm: "text-base",
  md: "text-2xl",
  lg: "text-4xl",
};

function formatPct(value: number | null | undefined) {
  if (value == null) return "—";
  return `${Math.round(value * 100)}%`;
}

export function JobSuccessScore({
  score,
  components,
  size = "md",
  className,
}: JobSuccessScoreProps) {
  if (score == null) {
    return (
      <div className={cn("text-ink-500", className)}>
        <p className={cn("font-medium", SIZES[size])}>Not yet rated</p>
        <p className="mt-1 text-xs">
          Score appears after 3 completed contracts
        </p>
      </div>
    );
  }

  return (
    <div className={cn("jss-tooltip inline-flex items-center gap-2", className)}>
      <div>
        <p className="text-xs font-semibold uppercase tracking-wider text-ink-500">
          Job Success Score
        </p>
        <p className={cn("font-serif font-medium text-jade-700", SIZES[size])}>
          {score}%
        </p>
      </div>
      {components && (
        <>
          <button
            type="button"
            className="text-ink-500 hover:text-ink-900"
            aria-label="How JSS is calculated"
          >
            <Info className="h-4 w-4" />
          </button>
          <div className="jss-tooltip-content" role="tooltip">
            <p className="font-semibold">Score breakdown</p>
            <ul className="mt-2 space-y-1">
              <li>Completion: {formatPct(components.completionRate)}</li>
              <li>On time: {formatPct(components.onTimeRate)}</li>
              <li>Rating: {components.avgRating?.toFixed(1) ?? "—"} / 5</li>
              <li>Dispute-free: {formatPct(components.disputeFreeRate)}</li>
              <li>Repeat clients: {formatPct(components.repeatClientRate)}</li>
            </ul>
            <p className="mt-2 text-bone/70">
              {components.completedContracts} completed contracts
            </p>
          </div>
        </>
      )}
    </div>
  );
}
